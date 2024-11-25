<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

// NOTE: Do not remove this line. Deserialization will fail.
use Symfony\Component\Serializer\Annotation\DiscriminatorMap;
use NineDigit\eKasa\Client\Models\Enums\ReceiptPrinterName;

/**
 * @DiscriminatorMap(typeProperty="name", mapping={
 *    "pos"="NineDigit\eKasa\Client\Models\Registrations\Receipts\PosRegisterReceiptPrintContextDto",
 *    "pdf"="NineDigit\eKasa\Client\Models\Registrations\Receipts\PdfRegisterReceiptPrintContextDto",
 *    "email"="NineDigit\eKasa\Client\Models\Registrations\Receipts\EmailRegisterReceiptPrintContextDto"
 * })
 */
abstract class RegisterReceiptPrintContextDto {
    /**
     * Názov tlačiarne, na ktorej bude doklad spracovaný.
     * Dostupné možnosti: pos, pdf, email.
     * @see ReceiptPrinterName
     */
    public ReceiptPrinterName $printerName;

    /**
     * Nastavenia tlačiarne.
     */
    // public ?ReceiptPrinterOptions $options;

    public function __construct(?ReceiptPrinterName $printerName/*, ?ReceiptPrinterOptions $options = null*/) {
        $this->printerName = $printerName;
        //$this->options = $options;
    }
}
