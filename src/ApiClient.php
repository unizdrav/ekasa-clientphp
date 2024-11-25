<?php

namespace NineDigit\eKasa\Client;

use InvalidArgumentException;
use NineDigit\eKasa\Client\Exceptions\ProblemDetailsException;
use NineDigit\eKasa\Client\Exceptions\ValidationProblemDetailsException;
use NineDigit\eKasa\Client\Models\CertificateInfoDto;
use NineDigit\eKasa\Client\Models\ConnectivityStatusDto;
use NineDigit\eKasa\Client\Models\EKasaProductInfoDto;
use NineDigit\eKasa\Client\Models\IdentityDto;
use NineDigit\eKasa\Client\Models\IndexTableStatusDto;
use NineDigit\eKasa\Client\Models\PrinterOpenDrawerRequestContextDto;
use NineDigit\eKasa\Client\Models\PrinterOpenDrawerResponseDto;
use NineDigit\eKasa\Client\Models\PrinterPrintRequestContextDto;
use NineDigit\eKasa\Client\Models\PrinterPrintResponseDto;
use NineDigit\eKasa\Client\Models\PrinterStatusDto;
use NineDigit\eKasa\Client\Models\QueueDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptNextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptRequestDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptsRequestDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptRequestContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptResultDto;
use NineDigit\eKasa\Client\Models\ResponseCount;
use NineDigit\eKasa\Client\Models\StorageReceiptLastDto;


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

  // Connectivity

    /**
     * Ziska informacie o stavu servera
     * @return ConnectivityStatusDto
     * @throws Exceptions\ApiAuthenticationException
     * @throws Exceptions\ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getConnectivity(): ConnectivityStatusDto
    {
        $apiRequest = ApiRequestBuilder::createGet("/v1/connectivity/status")->build();
        return $this->httpClient->receive($apiRequest, ConnectivityStatusDto::class);
    }

    // Index table

    public function getIndexTable(): IndexTableStatusDto
    {
        $apiRequest = ApiRequestBuilder::createGet("/v1/index_table/status")->build();
        return $this->httpClient->receive($apiRequest, IndexTableStatusDto::class);
    }

  // Product

  /**
   * Získanie informácii o pokladničnom programe a aktuálne pripojenom chránenom dátovom úložisku.
   */
  public function getProductInfo(): EKasaProductInfoDto {
    $apiRequest = ApiRequestBuilder::createGet("/v1/product/info")->build();
    return $this->httpClient->receive($apiRequest, EKasaProductInfoDto::class);
  }

  // Registrations

  /**
   * Zadá požiadavku na zaregistrovanie dokladu.
   * @throws ValidationProblemDetailsException ak nie je požiadavka valídna
   * @throws ProblemDetailsException
   * @throws ExposeException
   * @throws ApiAuthenticationException
   * @throws Exception
   */
  public function registerReceipt(RegisterReceiptRequestContextDto $context): RegisterReceiptResultDto {
    $apiRequest = ApiRequestBuilder::createPost("/v1/requests/receipts")
      ->withPayload($context)
      ->build();

    return $this->httpClient->receive($apiRequest, RegisterReceiptResultDto::class);
  }

    /**
     * Zadá požiadavku na ziskanie dokladov.
     * @param array $query
     * @return array|null
     * @throws Exceptions\ApiAuthenticationException
     * @throws Exceptions\ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getReceipts(array $query = []): ?array {
        $apiRequest = ApiRequestBuilder::createGet("/v1/requests/receipts")
            ->withQueryString($query)
            ->build();
        return $this->httpClient->receive($apiRequest, ReceiptsRequestDto::class."[]");
    }

    /**
     * Vytiahne pocet dokladov
     * @param array $query
     * @return ResponseCount
     * @throws \Exception
     */
    public function getCountReceipts(array $query): ResponseCount
    {
        $apiRequest = ApiRequestBuilder::createHead("/v1/requests/receipts")
            ->withQueryString($query)
            ->build();
        return $this->httpClient->receiveCountItem($apiRequest);
    }

    /**
     * Vytiahne doklad
     * @param array $query
     * @return ReceiptsRequestDto
     * @throws Exceptions\ApiAuthenticationException
     * @throws Exceptions\ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getReceipt(array $query = []): ReceiptsRequestDto {
        $apiRequest = ApiRequestBuilder::createGet("/v1/requests/receipts/receipt")
            ->withQueryString($query)
            ->build();
        return $this->httpClient->receive($apiRequest, ReceiptsRequestDto::class);
    }

    /**
     * Ziskanie cisla dalsieho dokladu
     * @param string $cashRegisterCode
     * @return ReceiptNextDto
     * @throws Exceptions\ApiAuthenticationException
     * @throws Exceptions\ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getReceiptNextNumber(string $cashRegisterCode): ReceiptNextDto
    {
        $apiRequest = ApiRequestBuilder::createGet("/v1/requests/receipts/next_number")
            ->withQueryString(["cashRegisterCode" => $cashRegisterCode])
            ->build();
        return $this->httpClient->receive($apiRequest, ReceiptNextDto::class);
    }

    /**
     * Vyvolá spracovanie nespracovaných požiadaviek
     * @param string $cashRegisterCode
     * @return ApiResponseMessage
     */
    public function processUnprocessedReceipt(string $cashRegisterCode): ApiResponseMessage
    {
        $apiRequest = ApiRequestBuilder::createPost("/v1/requests/unprocessed/process")
            ->withQueryString(["cashRegisterCode" => $cashRegisterCode])
            ->build();
        return $this->httpClient->receiveRaw($apiRequest);
    }

    // Certificates

    /**
     * Vypise vsetky certifikaty
     * @return array
     * @throws Exceptions\ApiAuthenticationException
     * @throws Exceptions\ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCertificates(): array
    {
        $apiRequest = ApiRequestBuilder::createGet("/v1/certificates")
            ->build();
        return $this->httpClient->receive($apiRequest, CertificateInfoDto::class."[]");
    }

    /**
     * Vypise posledny platny certifikat
     * @param string $cashRegisterCode
     * @return CertificateInfoDto
     * @throws Exceptions\ApiAuthenticationException
     * @throws Exceptions\ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getLatestValidCertificate(string $cashRegisterCode): CertificateInfoDto
    {
        $apiRequest = ApiRequestBuilder::createGet("/v1/certificates/valid/latest")
            ->withQueryString(["cashRegisterCode" => $cashRegisterCode])
            ->build();
        return $this->httpClient->receive($apiRequest, CertificateInfoDto::class);
    }

    /**
     * Vypise posledny certifikat
     * @param string $cashRegisterCode
     * @return CertificateInfoDto
     * @throws Exceptions\ApiAuthenticationException
     * @throws Exceptions\ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getLatestCertificate(string $cashRegisterCode): CertificateInfoDto
    {
        $apiRequest = ApiRequestBuilder::createGet("/v1/certificates/latest")
            ->withQueryString(["cashRegisterCode" => $cashRegisterCode])
            ->build();
        return $this->httpClient->receive($apiRequest, CertificateInfoDto::class);
    }

    //Queue

    /**
     * Vypise vsetky nespracovane doklady
     * @param array $query
     * @return array
     * @throws Exceptions\ApiAuthenticationException
     * @throws Exceptions\ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUnprocessedReceipts(array $query = []): array
    {
        $apiRequest = ApiRequestBuilder::createGet("/v1/queue/items/unprocessed")
            ->withQueryString($query)
            ->build();

        return $this->httpClient->receive($apiRequest, QueueDto::class."[]");
    }

    //Storage

    /**
     * Vypise posledne poradove cislo v ulozisku
     * @param array $query
     * @return StorageReceiptLastDto
     * @throws Exceptions\ApiAuthenticationException
     * @throws Exceptions\ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getStorageReceiptLastNumber(array $query = []): StorageReceiptLastDto
    {
        $apiRequest = ApiRequestBuilder::createGet("/v1/storage/last_receipt_number")
            ->withQueryString($query)
            ->build();

        return $this->httpClient->receive($apiRequest, StorageReceiptLastDto::class);
    }

    //Printer

    /**
     * Zisti stav tlaciarne
     * @return PrinterStatusDto
     * @throws Exceptions\ApiAuthenticationException
     * @throws Exceptions\ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPrinterStatus(): PrinterStatusDto
    {
        $apiRequest = ApiRequestBuilder::createGet("/v1/printers/status")
            ->build();

        return $this->httpClient->receive($apiRequest, PrinterStatusDto::class);
    }

    /**
     * Vrati pdf stream pre doklad
     * @param array $query
     * @return string|null
     */
    public function getPdfStream(array $query = []): ?string
    {
        $apiRequest = ApiRequestBuilder::createGet("/v1/printers/pdf/receipt")
            ->withQueryString($query)
            ->build();

        return $this->httpClient->receiveRaw($apiRequest)->getContent();
    }

    /**
     * Otvori penažnu zásuvku
     * @param PrinterOpenDrawerRequestContextDto $context
     * @param array $query
     * @return PrinterOpenDrawerResponseDto
     * @throws Exceptions\ApiAuthenticationException
     * @throws Exceptions\ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function openDrawer(PrinterOpenDrawerRequestContextDto $context,array $query = []): PrinterOpenDrawerResponseDto
    {
        $apiRequest = ApiRequestBuilder::createPost("/v1/printers/open_drawer")
            ->withQueryString($query)
            ->withPayload($context)
            ->build();

        return $this->httpClient->receive($apiRequest, PrinterOpenDrawerResponseDto::class);
    }

    /**
     * Vytlaci nefiškálny doklad
     * @param PrinterPrintRequestContextDto $context
     * @return PrinterPrintResponseDto
     * @throws Exceptions\ApiAuthenticationException
     * @throws Exceptions\ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function print(PrinterPrintRequestContextDto $context): PrinterPrintResponseDto
    {
        $apiRequest = ApiRequestBuilder::createPost("/v1/printers/print")
            ->withPayload($context)
            ->build();

        return $this->httpClient->receive($apiRequest, PrinterPrintResponseDto::class);
    }

    /**
     * Vytlací doklad
     * @param array $query
     * @return PrinterPrintResponseDto
     * @throws Exceptions\ApiAuthenticationException
     * @throws Exceptions\ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function printCopyReceipt(array $query=[]): PrinterPrintResponseDto
    {
        $apiRequest = ApiRequestBuilder::createPost("/v1/requests/receipts/print_copy")
            ->withQueryString($query)
            ->build();

        return $this->httpClient->receive($apiRequest, PrinterPrintResponseDto::class);
    }

    /**
     * Vytlačí nespracované požiadavky
     * @param array $query
     * @return PrinterPrintResponseDto
     * @throws Exceptions\ApiAuthenticationException
     * @throws Exceptions\ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function printUnprocessedReceipt(array $query=[]): PrinterPrintResponseDto
    {
        $apiRequest = ApiRequestBuilder::createPost("/v1/requests/unprocessed/print")
            ->withQueryString($query)
            ->build();

        return $this->httpClient->receive($apiRequest, PrinterPrintResponseDto::class);
    }

    // Identities

    /**
     * Vráti vsetky identity
     * @return array
     * @throws Exceptions\ApiAuthenticationException
     * @throws Exceptions\ExposeException
     * @throws ProblemDetailsException
     * @throws ValidationProblemDetailsException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getIdentities(): array
    {
        $apiRequest = ApiRequestBuilder::createGet("/v1/identities")
            ->build();

        return $this->httpClient->receive($apiRequest, IdentityDto::class."[]");
    }

}
