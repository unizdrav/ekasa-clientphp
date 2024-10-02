<?php

namespace NineDigit\eKasa\Client\Tests;

use NineDigit\eKasa\Client\ApiClientOptions;
use NineDigit\eKasa\Client\ApiRequest;
use NineDigit\eKasa\Client\ApiRequestMessage;
use NineDigit\eKasa\Client\ApiResponseMessage;
use NineDigit\eKasa\Client\HttpClient;


final class TestableHttpClient extends HttpClient
{
    public function __construct(ApiClientOptions $options)
	{
        parent::__construct($options);   
    }

    public function callThrowOnError(ApiResponseMessage $response)
    {
        return $this->throwOnError($response);
    }

    public function callDeserializeResponseMessage(ApiResponseMessage $response, $classType)
    {
        return $this->deserializeResponseMessage($response, $classType);
    }

    public function callCreateRequestMessage(ApiRequest $request): ApiRequestMessage
    {
        return $this->createRequestMessage($request);
    }
}
