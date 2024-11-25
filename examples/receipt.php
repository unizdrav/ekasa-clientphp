<?php

namespace NineDigit\eKasa\Client\Examples;

use Error;
use NineDigit\eKasa\Client\AccessTokenSource;
use NineDigit\eKasa\Client\ApiClientAuthenticationAccessTokenOptions;
use NineDigit\eKasa\Client\ApiClientAuthenticationOptions;
use NineDigit\eKasa\Client\Credentials;
use NineDigit\eKasa\Client\EKasaServer;
use NineDigit\eKasa\Client\ApiClient;
use NineDigit\eKasa\Client\ApiClientOptions;
use NineDigit\eKasa\Client\Exceptions\ProblemDetailsException;
use NineDigit\eKasa\Client\Models\Enums\PrinterDrawerPin;
use NineDigit\eKasa\Client\Models\PrinterOpenDrawerRequestContextDto;
use NineDigit\eKasa\Client\Models\PrinterPrintRequestContextDto;
use NineDigit\eKasa\Client\Models\QuantityDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\EmailRegisterReceiptPrintContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\PdfReceiptPrinterOptions;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\PdfRegisterReceiptPrintContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\PosReceiptPrinterOptions;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\EmailReceiptPrinterOptions;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\PosRegisterReceiptPrintContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptBuilder;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptItemBuilder;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptItemDto;
use NineDigit\eKasa\Client\Models\Enums\ReceiptItemType;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptPaymentDto;
use NineDigit\eKasa\Client\Models\Enums\ReceiptPaymentName;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptRequestContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptRequestDto;

require '../vendor/autoload.php';

$url = "http://192.168.5.144:3010/api";

$clientOptions = new ApiClientOptions($url);
$client = new ApiClient($clientOptions);

$cashRegisterCode = "88812345678900001";

$externalId = 1234;

// 2.1. Tlačiareň papierových dokladov
$posPrinterOptions = new PosReceiptPrinterOptions();
$posPrinterOptions->openDrawer = true;
$print = new PosRegisterReceiptPrintContextDto($posPrinterOptions);

// Položky dokladu

$items = array(
    new ReceiptItemDto(
        ReceiptItemType::POSITIVE, // Kladný typ položky
        "Coca Cola 0.25l", // Názov
        1.29, // Jednotková cena
        20.00, // Daňová hladina
        new QuantityDto(2, "ks"), // Množstvo
        2.58 // Cena
    )
);

// Doklad
$receipt = ReceiptBuilder::cashRegister($cashRegisterCode, $items)
    ->setRoundingAmount(0.02)
    ->addPayment(new ReceiptPaymentDto(4.00, ReceiptPaymentName::CASH))
    ->addPayment(new ReceiptPaymentDto(-0.50, ReceiptPaymentName::EXPENSE))
    ->setHeaderText("Nine Digit, s.r.o.") // Voliteľná hlavička dokladu
    ->setFooterText("Ďakujeme za nákup!") // Voliteľná pätička dokladu
    ->build();

$request = new RegisterReceiptRequestDto($receipt, $externalId);
$requestContext = new RegisterReceiptRequestContextDto($print, $request);

$receiptCount = $client->getCountReceipts($cashRegisterCode);
$info = $client->getReceipts(["externalId"=>"e52ff4d1-f2ed-4493-9e9a-a73739b1ba23"]);
$receiptNext = $client->getReceiptNextNumber($cashRegisterCode);

$receipt = $client->getReceipt($cashRegisterCode,["id"=>"b1e7c47e-3a2d-4731-9a41-9daaee859974"]);

$certificates = $client->getCertificates();
$certificateLastValidInfo = $client->getLatestValidCertificate($cashRegisterCode);
$certificateLastInfo = $client->getLatestCertificate($cashRegisterCode);

$queue = $client->getUnprocessedReceipts($cashRegisterCode);

$lastStorage = $client->getStorageReceiptLastNumber($cashRegisterCode);

$printerStatus = $client->getPrinterStatus();
//$printPdf = $client->getPdfStream(["cashRegisterCode"=>$cashRegisterCode,"id"=>"b1e7c47e-3a2d-4731-9a41-9daaee859974"]);

$connectivity = $client->getConnectivity();
$indexTable = $client->getIndexTable();

$openDrawer = $client->openDrawer(new PrinterOpenDrawerRequestContextDto(PrinterDrawerPin::Pin2), $cashRegisterCode);
$print = $client->print(new PrinterPrintRequestContextDto("This is the content of non-fiscal print output. Please see formatting options in the documentation.",$cashRegisterCode));
$printCopy = $client->printCopyReceipt($cashRegisterCode,["id"=>"b1e7c47e-3a2d-4731-9a41-9daaee859974"]);

$identites = $client->getIdentities();

$proccess = $client->processUnprocessedReceipt($cashRegisterCode);

$printUnprocessedReceipt = $client->printUnprocessedReceipt($cashRegisterCode);

$getCountUnprocessedReceipts = $client->getCountUnprocessedReceipts($cashRegisterCode);

// Zaslanie požidavky a obdržanie výsledku
$result = $client->registerReceipt($requestContext);

var_dump($result);
