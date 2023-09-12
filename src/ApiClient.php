<?php

namespace NineDigit\eKasa\Client;

use InvalidArgumentException;
use NineDigit\eKasa\Client\Exceptions\ProblemDetailsException;
use NineDigit\eKasa\Client\Exceptions\ValidationProblemDetailsException;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptRequestContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptResultDto;


final class ApiClient {
  private HttpClientInterface $httpClient;

  /**
   * @param $optionsOrClient ApiClientOptions | HttpClientInterface
   * Akceptuje ApiClientOptions alebo HttpClientInterface.
   * Preťaženie s HttpClientInterface sa využíva iba na testovacie účely. Využívajte preťaženie
   * akceptujúce ApiClientOptions.
   */
  public function __construct($optionsOrClient) {
    if ($optionsOrClient instanceof ApiClientOptions) {
      $this->httpClient = new HttpClient($optionsOrClient);
    } else if (is_subclass_of($optionsOrClient, HttpClientInterface::class)) {
      $this->httpClient = $optionsOrClient;
    } else {
      throw new InvalidArgumentException("Expecting ". ApiClientOptions::class ." or ". HttpClientInterface::class . " type as an argument.");
    }
  }

  // Registrations

  /**
   * Zadá požiadavku na zaregistrovanie dokladu.
   * @throws ValidationProblemDetailsException ak nie je požiadavka valídna
   * @throws ProblemDetailsException
   */
  public function registerReceipt(RegisterReceiptRequestContextDto $context): RegisterReceiptResultDto {
    $apiRequest = ApiRequestBuilder::createPost("/v1/requests/receipts")
      ->withPayload($context)
      ->build();

      return $this->httpClient->receive($apiRequest, RegisterReceiptResultDto::class);
  }
}