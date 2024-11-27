<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

use NineDigit\eKasa\Client\Models\Enums\ReceiptPrinterName;

final class PdfRegisterReceiptPrintContextDto extends RegisterReceiptPrintContextDto {
    /**
     * Nastavenia tlačiarne.
     */
    public PdfReceiptPrinterOptions $options;

    public function __construct(?PdfReceiptPrinterOptions $options = null) {
        $this->options = $options ?? new PdfReceiptPrinterOptions();
        parent::__construct(ReceiptPrinterName::PDF);
    }
}
