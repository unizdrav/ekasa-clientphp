<?php

namespace NineDigit\eKasa\Client\Examples;

/*use Error;
use NineDigit\eKasa\Client\AccessTokenSource;
use NineDigit\eKasa\Client\ApiClientAuthenticationAccessTokenOptions;
use NineDigit\eKasa\Client\ApiClientAuthenticationOptions;
use NineDigit\eKasa\Client\Credentials;
use NineDigit\eKasa\Client\EKasaServer;
use NineDigit\eKasa\Client\ApiClient;
use NineDigit\eKasa\Client\ApiClientOptions;
use NineDigit\eKasa\Client\Exceptions\ProblemDetailsException;
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
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptItemType;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptPaymentDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptPaymentName;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptRequestContextDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\RegisterReceiptRequestDto;

require '../vendor/autoload.php';

$url = "http://192.168.5.144:3010/api";

$clientOptions = new ApiClientOptions($url);
$client = new ApiClient($clientOptions);

$cashRegisterCode = "88812345678900001";

$receiptCount = $client->getCountReceipts(["cashRegisterCode"=>$cashRegisterCode]);
$info = $client->getReceipts(["externalId"=>"e52ff4d1-f2ed-4493-9e9a-a73739b1ba23"]);
$receiptNext = $client->getReceiptNextNumber($cashRegisterCode);

$receipt = $client->getReceipt(["cashRegisterCode"=>$cashRegisterCode,"id"=>"b1e7c47e-3a2d-4731-9a41-9daaee859974"]);

$certificates = $client->getCertificates();
$certificateLastValidInfo = $client->getLatestValidCertificate($cashRegisterCode);
$certificateLastInfo = $client->getLatestCertificate($cashRegisterCode);

$queue = $client->getUnprocessedReceipts(["cashRegisterCode"=>$cashRegisterCode]);

$lastStorage = $client->getStorageReceiptLastNumber(["cashRegisterCode"=>$cashRegisterCode]);

$printerStatus = $client->getPrinterStatus();
//$printPdf = $client->getPdfStream(["cashRegisterCode"=>$cashRegisterCode,"id"=>"b1e7c47e-3a2d-4731-9a41-9daaee859974"]);

$connectivity = $client->getConnectivity();
$indexTable = $client->getIndexTable();

$openDrawer = $client->openDrawer(new PrinterOpenDrawerRequestContextDto("Pin2"), ["cashRegisterCode"=>$cashRegisterCode]);
$print = $client->print(new PrinterPrintRequestContextDto("This is the content of non-fiscal print output. Please see formatting options in the documentation.",$cashRegisterCode));
$printCopy = $client->printCopyReceipt(["cashRegisterCode"=>$cashRegisterCode,"id"=>"b1e7c47e-3a2d-4731-9a41-9daaee859974"]);

$identites = $client->getIdentities();

$proccess = $client->processUnprocessedReceipt($cashRegisterCode);

$printUnprocessedReceipt = $client->printUnprocessedReceipt(["cashRegisterCode"=>$cashRegisterCode]);

var_dump($printUnprocessedReceipt);*/
