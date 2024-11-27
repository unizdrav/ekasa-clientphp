<?php

namespace NineDigit\eKasa\Client\Tests\Integration;

use Error;
use Exception;
use JsonException;
use NineDigit\eKasa\Client\Models\Enums\PrinterDrawerPin;
use NineDigit\eKasa\Client\Models\PrinterOpenDrawerRequestContextDto;
use NineDigit\eKasa\Client\Models\PrinterPrintRequestContextDto;
use NineDigit\eKasa\Client\Models\ResponseCount;
use PHPUnit\Framework\TestCase;

use NineDigit\eKasa\Client\Models\Registrations\Receipts\PosRegisterReceiptPrintContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptBuilder;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptItemBuilder;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptPaymentDto;
use NineDigit\eKasa\Client\Models\Enums\ReceiptPaymentName;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptRequestContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptRequestDto;
use NineDigit\eKasa\Client\ApiClient;
use NineDigit\eKasa\Client\Models\QuantityDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\PosReceiptPrinterOptions;

function getGUID(): string {
    if (function_exists('com_create_guid')){
        $uuid = com_create_guid();
    }
    else {
        mt_srand(intval((double)microtime()*10000));//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
    }

    return trim($uuid, "{}");
}

final class ApiClientIntegrationTest extends TestCase {

    /**
     * @throws JsonException
     */
    private function getSettings(): ApiClientIntegrationTestOptions {
        return ApiClientIntegrationTestOptions::load(dirname(__FILE__) . '/settings.json');
    }

    public function testGetProductInfo() {
        $settings = $this->getSettings();
        $apiClient = new ApiClient($settings->apiClientOptions);
        $throws = false;

        try
        {
            $result = $apiClient->getProductInfo();
        }
        catch (Exception | Error $e)
        {
            $throws = true;
        }

        $this->assertFalse($throws);
    }

    public function testRegisterCashRegisterReceiptUsingPosPrinter() {
        $settings = $this->getSettings();
        $apiClient = new ApiClient($settings->apiClientOptions);

        $cashRegisterCode = "88812345678900001";
        $externalId = getGUID();
        $items = array(
            ReceiptItemBuilder::positive("CocaCola 0.25l", 1.48, 20, new QuantityDto(1, "ks"), 1.48)->build(),
            ReceiptItemBuilder::positive("Sprite 0.25l", 2.00, 20, new QuantityDto(1, "ks"), 2.00)->build()
        );

        $printOptions = new PosReceiptPrinterOptions();
        $print = new PosRegisterReceiptPrintContextDto($printOptions);

        $receipt = ReceiptBuilder::cashRegister($cashRegisterCode, $items)
            ->setRoundingAmount(0.02)
            ->addPayment(new ReceiptPaymentDto(4.00, ReceiptPaymentName::CASH))
            ->addPayment(new ReceiptPaymentDto(-0.50, "Výdavok"))
            ->setHeaderText("Nine Digit, s.r.o.")
            ->setFooterText("Ďakujeme za nákup!")
            ->build();

        $request = new RegisterReceiptRequestDto($receipt, $externalId);
        $requestContext = new RegisterReceiptRequestContextDto($print, $request);
        $throws = false;

        try
        {
            $result = $apiClient->registerReceipt($requestContext);
        }
        catch (Exception | Error $e)
        {
            $throws = true;
        }

        $this->assertFalse($throws);
    }

    public function testGetCertificates() {
        $settings = $this->getSettings();
        $apiClient = new ApiClient($settings->apiClientOptions);
        $throws = false;

        try
        {
            $result = $apiClient->getCertificates();
        }
        catch (Exception | Error $e)
        {
            $throws = true;
        }

        $this->assertFalse($throws);
    }

    public function testGetLatestValidCertificate() {
        $settings = $this->getSettings();
        $apiClient = new ApiClient($settings->apiClientOptions);
        $cashRegisterCode = "88812345678900001";
        $throws = false;

        try
        {
            $result = $apiClient->getLatestValidCertificate($cashRegisterCode);
        }
        catch (Exception | Error $e)
        {
            $throws = true;
        }

        $this->assertFalse($throws);
    }

    public function testGetLatestCertificate() {
        $settings = $this->getSettings();
        $apiClient = new ApiClient($settings->apiClientOptions);
        $cashRegisterCode = "88812345678900001";
        $throws = false;

        try
        {
            $result = $apiClient->getLatestCertificate($cashRegisterCode);
        }
        catch (Exception | Error $e)
        {
            $throws = true;
        }

        $this->assertFalse($throws);
    }

    public function testGetUnprocessedReceipts() {
        $settings = $this->getSettings();
        $apiClient = new ApiClient($settings->apiClientOptions);
        $cashRegisterCode = "88812345678900001";
        $throws = false;

        try
        {
            $result = $apiClient->getUnprocessedReceipts($cashRegisterCode);
        }
        catch (Exception | Error $e)
        {
            $throws = true;
        }

        $this->assertFalse($throws);
    }

    public function testGetStorageReceiptLastNumber() {
        $settings = $this->getSettings();
        $apiClient = new ApiClient($settings->apiClientOptions);
        $cashRegisterCode = "88812345678900001";
        $throws = false;

        try
        {
            $result = $apiClient->getStorageReceiptLastNumber($cashRegisterCode);
        }
        catch (Exception | Error $e)
        {
            $throws = true;
        }

        $this->assertFalse($throws);
    }

    public function testGetPrinterStatus() {
        $settings = $this->getSettings();
        $apiClient = new ApiClient($settings->apiClientOptions);
        $throws = false;

        try
        {
            $result = $apiClient->getPrinterStatus();
        }
        catch (Exception | Error $e)
        {
            $throws = true;
        }

        $this->assertFalse($throws);
    }

    public function testGetConnectivity() {
        $settings = $this->getSettings();
        $apiClient = new ApiClient($settings->apiClientOptions);
        $throws = false;

        try
        {
            $result = $apiClient->getConnectivity();
        }
        catch (Exception | Error $e)
        {
            $throws = true;
        }

        $this->assertFalse($throws);
    }

    public function testGetIndexTable() {
        $settings = $this->getSettings();
        $apiClient = new ApiClient($settings->apiClientOptions);
        $throws = false;

        try
        {
            $result = $apiClient->getIndexTable();
        }
        catch (Exception | Error $e)
        {
            $throws = true;
        }

        $this->assertFalse($throws);
    }

    public function testOpenDrawer() {
        $settings = $this->getSettings();
        $apiClient = new ApiClient($settings->apiClientOptions);
        $throws = false;
        $cashRegisterCode = "88812345678900001";

        try
        {
            $result = $apiClient->openDrawer(new PrinterOpenDrawerRequestContextDto(PrinterDrawerPin::Pin2), $cashRegisterCode);
        }
        catch (Exception | Error $e)
        {
            $throws = true;
        }

        $this->assertFalse($throws);
    }

    public function testPrint() {
        $settings = $this->getSettings();
        $apiClient = new ApiClient($settings->apiClientOptions);
        $throws = false;
        $cashRegisterCode = "88812345678900001";

        try
        {
            $result = $apiClient->print(new PrinterPrintRequestContextDto("Content",$cashRegisterCode));
        }
        catch (Exception | Error $e)
        {
            $throws = true;
        }

        $this->assertFalse($throws);
    }

    public function testGetIdentities() {
        $settings = $this->getSettings();
        $apiClient = new ApiClient($settings->apiClientOptions);
        $throws = false;

        try
        {
            $result = $apiClient->getIdentities();
        }
        catch (Exception | Error $e)
        {
            $throws = true;
        }

        $this->assertFalse($throws);
    }

    public function testProcessUnprocessedReceipt() {
        $settings = $this->getSettings();
        $apiClient = new ApiClient($settings->apiClientOptions);
        $cashRegisterCode = "88812345678900001";
        $throws = false;

        try
        {
            $result = $apiClient->processUnprocessedReceipt($cashRegisterCode);
        }
        catch (Exception | Error $e)
        {
            $throws = true;
        }

        $this->assertFalse($throws);
    }

    public function testPrintUnprocessedReceipt() {
        $settings = $this->getSettings();
        $apiClient = new ApiClient($settings->apiClientOptions);
        $cashRegisterCode = "88812345678900001";
        $throws = false;

        try
        {
            $result = $apiClient->printUnprocessedReceipt($cashRegisterCode);
        }
        catch (Exception | Error $e)
        {
            $throws = true;
        }

        $this->assertFalse($throws);
    }

    public function testGetCountUnprocessedReceipts() {
        $settings = $this->getSettings();
        $apiClient = new ApiClient($settings->apiClientOptions);
        $cashRegisterCode = "88812345678900001";
        $throws = false;
        $result = null;

        try
        {
            $result = $apiClient->getCountUnprocessedReceipts($cashRegisterCode);
        }
        catch (Exception | Error $e)
        {
            $throws = true;
        }

        $this->assertFalse($throws);
        $this->assertInstanceOf(ResponseCount::class,$result);
    }

//    public function testRegisterReceiptUsingPosPrinterWithNonEmptyOptions() {
//        $settings = $this->getDemoAccountSettings();
//        $apiClient = new ApiClient($settings->apiClientOptions);
//
//        $posPrinterOptions = new PosReceiptPrinterOptions();
//        $posPrinterOptions->openDrawer = true;
//        $receiptPrinter = new PosReceiptPrinterDto($posPrinterOptions);
//
//        $cashRegisterCode = $settings->cashRegisterCode;
//        $externalId = getGUID();
//
//        $item = new ReceiptRegistrationItemDto(
//            ReceiptItemType::POSITIVE,
//            "Coca Cola 0.25l",
//            1.29,
//            20.00,
//            new QuantityDto(2, "ks"),
//            2.58
//        );
//
//        $payment = new ReceiptRegistrationPaymentDto(2.58, "Hotovosť");
//
//        $receiptRegistrationRequest = new Receipts\CreateReceiptRegistrationRequestDto(
//            ReceiptType::CASH_REGISTER,
//            $cashRegisterCode,
//            $externalId,
//            [$item],
//            [$payment]
//        );
//
//        $receiptRegistrationRequest->headerText = "www.ninedigit.sk";
//        $receiptRegistrationRequest->footerText = "Ďakujeme za váš nákup.";
//
//        $validityTimeSpan = $settings->validityTimeSpan;
//
//        $createReceiptRegistration = new CreateReceiptRegistrationDto(
//            $receiptPrinter, $receiptRegistrationRequest, $validityTimeSpan);
//
//        $receiptRegistration = $apiClient->registerReceipt($createReceiptRegistration);
//
//        $this->assertEquals(RegistrationState::PROCESSED, $receiptRegistration->state);
//    }
//
//    public function testRegisterReceiptUsingPosPrinterWithNonEmptyOptionsAsExpired() {
//        $settings = $this->getDemoAccountSettings();
//        $apiClient = new ApiClient($settings->apiClientOptions);
//
//        $posPrinterOptions = new PosReceiptPrinterOptions();
//        $posPrinterOptions->openDrawer = true;
//        $receiptPrinter = new PosReceiptPrinterDto($posPrinterOptions);
//
//        // $receiptPrinter = new PdfRegisterReceiptPrintContextDto($pdfPrinterOptions);
//
//        // $emailPrinterOptions = new EmailReceiptPrinterOptions("mail@example.com");
//        // $emailPrinterOptions->subject = "Váš elektronický doklad";
//        // $receiptPrinter = new EmailRegisterReceiptPrintContextDto($emailPrinterOptions);
//
//        $cashRegisterCode = $settings->cashRegisterCode;
//        $externalId = "e52ff4d1-f2ed-4493-9e9a-a73739b1ba23";
//
//        $item = new ReceiptRegistrationItemDto(
//            ReceiptItemType::POSITIVE,
//            "Coca Cola 0.25l",
//            1.29,
//            20.00,
//            new QuantityDto(2, "ks"),
//            2.58
//        );
//
//        $payment = new ReceiptRegistrationPaymentDto(2.58, "Hotovosť");
//
//        $receiptRegistrationRequest = new Receipts\CreateReceiptRegistrationRequestDto(
//            ReceiptType::CASH_REGISTER,
//            $cashRegisterCode,
//            $externalId,
//            [$item],
//            [$payment]
//        );
//
//        $receiptRegistrationRequest->headerText = "www.ninedigit.sk";
//        $receiptRegistrationRequest->footerText = "Ďakujeme za váš nákup.";
//
//        $validityTimeSpan = 0;
//
//        $createReceiptRegistration = new CreateReceiptRegistrationDto(
//            $receiptPrinter, $receiptRegistrationRequest, $validityTimeSpan);
//
//        $receiptRegistration = $apiClient->registerReceipt($createReceiptRegistration);
//
//        $this->assertNotEquals(RegistrationState::FAILED, $receiptRegistration->state);
//    }
//
//    public function testRegisterReceiptUsingEmailPrinter() {
//        $settings = $this->getDemoAccountSettings();
//        $apiClient = new ApiClient($settings->apiClientOptions);
//
//        $emailPrinterOptions = new EmailReceiptPrinterOptions("mail@example.com");
//        $emailPrinterOptions->subject = "Váš elektronický doklad";
//        $receiptPrinter = new EmailReceiptPrinterDto($emailPrinterOptions);
//
//        $cashRegisterCode = $settings->cashRegisterCode;
//        $externalId = "e52ff4d1-f2ed-4493-9e9a-a73739b1ba23";
//
//        $item = new ReceiptRegistrationItemDto(
//            ReceiptItemType::POSITIVE,
//            "Coca Cola 0.25l",
//            1.29,
//            20.00,
//            new QuantityDto(2, "ks"),
//            2.58
//        );
//
//        $payment = new ReceiptRegistrationPaymentDto(2.58, "Hotovosť");
//
//        $receiptRegistrationRequest = new Receipts\CreateReceiptRegistrationRequestDto(
//            ReceiptType::CASH_REGISTER,
//            $cashRegisterCode,
//            $externalId,
//            [$item],
//            [$payment]
//        );
//
//        $receiptRegistrationRequest->headerText = "www.ninedigit.sk";
//        $receiptRegistrationRequest->footerText = "Ďakujeme za váš nákup.";
//
//        $validityTimeSpan = 1;
//
//        $createReceiptRegistration = new CreateReceiptRegistrationDto(
//            $receiptPrinter, $receiptRegistrationRequest, $validityTimeSpan);
//
//        $receiptRegistration = $apiClient->registerReceipt($createReceiptRegistration);
//
//        $this->assertNotEquals(RegistrationState::FAILED, $receiptRegistration->state);
//    }
//
//    public function testRegisterReceiptUsingPdfPrinter() {
//        $settings = $this->getDemoAccountSettings();
//        $apiClient = new ApiClient($settings->apiClientOptions);
//
//        $pdfPrinterOptions = new PdfReceiptPrinterOptions();
//        $receiptPrinter = new PdfReceiptPrinterDto($pdfPrinterOptions);
//
//        $cashRegisterCode = $settings->cashRegisterCode;
//        $externalId = "e52ff4d1-f2ed-4493-9e9a-a73739b1ba23";
//
//        $item = new ReceiptRegistrationItemDto(
//            ReceiptItemType::POSITIVE,
//            "Coca Cola 0.25l",
//            1.29,
//            20.00,
//            new QuantityDto(2, "ks"),
//            2.58
//        );
//
//        $payment = new ReceiptRegistrationPaymentDto(2.58, "Hotovosť");
//
//        $receiptRegistrationRequest = new Receipts\CreateReceiptRegistrationRequestDto(
//            ReceiptType::CASH_REGISTER,
//            $cashRegisterCode,
//            $externalId,
//            [$item],
//            [$payment]
//        );
//
//        $receiptRegistrationRequest->headerText = "www.ninedigit.sk";
//        $receiptRegistrationRequest->footerText = "Ďakujeme za váš nákup.";
//
//        $validityTimeSpan = 1;
//
//        $createReceiptRegistration = new CreateReceiptRegistrationDto(
//            $receiptPrinter, $receiptRegistrationRequest, $validityTimeSpan);
//
//        $receiptRegistration = $apiClient->registerReceipt($createReceiptRegistration);
//
//        $this->assertNotEquals(RegistrationState::FAILED, $receiptRegistration->state);
//    }
}
