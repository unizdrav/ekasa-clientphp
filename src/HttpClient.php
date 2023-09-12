<?php

namespace NineDigit\eKasa\Client;

use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

use NineDigit\eKasa\Client\Exceptions\ProblemDetailsException;
use NineDigit\eKasa\Client\Serialization\SerializerInterface;
use NineDigit\eKasa\Client\Exceptions\ValidationProblemDetailsException;

use NineDigit\eKasa\Client\Models\ProblemDetails;
use NineDigit\eKasa\Client\Models\ValidationProblemDetails;
use NineDigit\eKasa\Client\Serialization\SymfonyJsonSerializer;

final class HttpClient implements HttpClientInterface
{
    private SerializerInterface $serializer;
    private array $defaultHttpHeaders;
    private array $defaultQueryString;
    private GuzzleHttpClient $client;
    private string $url;

    public function __construct(ApiClientOptions $options)
    {
        $this->url = $options->url;
        $this->defaultHttpHeaders = array();
        $this->defaultQueryString = array();
        $this->serializer = $options->serializer ?? new SymfonyJsonSerializer();

        $guzzleHttpClientConfig = [
            //"base_uri" => $this->url
        ];

        if (!empty($options->proxyUrl)) {
            $guzzleHttpClientConfig["proxy"] = $options->proxyUrl;
        }

        if ($options->authentication !== null) {
            if ($options->authentication->credentials != null) {
                $guzzleHttpClientConfig["auth"] = [
                    $options->authentication->credentials->userName,
                    $options->authentication->credentials->password];
            }

            if ($options->authentication->accessToken !== null) {
                $keyName = $options->authentication->accessToken->source->keyName;
                switch ($options->authentication->accessToken->source->name) {
                    case AccessTokenSourceName::HEADER:
                        $this->defaultHttpHeaders[$keyName] = $options->authentication->accessToken->value;
                        break;
                    case AccessTokenSourceName::QUERY_STRING:
                        $this->defaultQueryString[$keyName] = $options->authentication->accessToken->value;
                        break;
                }
            }
        }

        $this->client = new GuzzleHttpClient($guzzleHttpClientConfig);
    }

    /**
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     */
    public function send(ApiRequest $request): void
    {
        $requestMessage = $this->createRequestMessage($request);
        $responseMessage = $this->sendRequestMessage($requestMessage);
        $this->throwOnError($responseMessage);
    }

    /**
     * @throws ProblemDetailsException
     */
    public function receive(ApiRequest $request, $type)
    {
        $requestMessage = $this->createRequestMessage($request);
        $responseMessage = $this->sendRequestMessage($requestMessage);
        return $this->deserializeResponseMessage($responseMessage, $type);
    }

    private function createRequestMessage(ApiRequest $request): ApiRequestMessage
    {
        $body = $this->serializer->serialize($request->payload);
        $headers = array_merge($this->defaultHttpHeaders, $request->headers);
        $queryString = array_merge($this->defaultQueryString, $request->queryString);

        if (!array_key_exists("Content-Type", $headers) || empty($headers["Content-Type"])) {
            $headers["Content-Type"] = "application/json; charset=utf-8";
        }

        if (!array_key_exists("Accept", $headers) || empty($headers["Accept"])) {
            $headers["Accept"] = "application/json";
        }

        // https://stackoverflow.com/a/57226671/1391492

        $path = trim($request->path, "/");
        $url = rtrim($this->url, "/") . "/" . $path;

        if (count($queryString) > 0) {
            $url .= "?" . htmlspecialchars(http_build_query($queryString, "", "&", PHP_QUERY_RFC3986));
        }

        return new ApiRequestMessage($request->method, $url, $headers, $body);
    }

    /**
     * @throws GuzzleException
     */
    private function sendRequestMessage(ApiRequestMessage $request): ApiResponseMessage
    {
        $headers = array();

        try {
            $guzzleRequest = new Request(
                $request->method,
                $request->url,
                $request->headers,
                $request->body);

            $guzzleResponse = $this->client->send($guzzleRequest, ["debug" => true]);
            $body = $guzzleResponse->getBody();
        } catch (RequestException $ex) {
            if ($ex->hasResponse()) {
                $guzzleResponse = $ex->getResponse();
                $body = $ex->getResponse()->getBody()->getContents();
            } else {
                throw $ex;
            }
        }

        foreach ($guzzleResponse->getHeaders() as $key => $value)
            $headers[$key] = $value;

        $response = new ApiResponseMessage();
        $response->statusCode = $guzzleResponse->getStatusCode();
        $response->headers = $headers;
        $response->body = $body;

        return $response;
    }

    /**
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     */
    private function deserializeResponseMessage(ApiResponseMessage $response, $classType)
    {
        $this->throwOnError($response);
        return $this->serializer->deserialize($response->body, $classType);
    }

    /**
     * @throws Exception
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     */
    private function throwOnError(ApiResponseMessage $response): void
    {
        if ($response->isSuccessStatusCode()) {
            return;
        }

        if ($response->statusCode === 400 || $response->statusCode === 422) {
            $validationProblemDetails = $this->serializer->deserialize($response->body, ValidationProblemDetails::class);
            throw new ValidationProblemDetailsException($validationProblemDetails);
        } else {
            $problemDetails = $this->serializer->deserialize($response->body, ProblemDetails::class);
            throw new Exceptions\ProblemDetailsException($problemDetails);
        }
    }
}