<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;
use NineDigit\eKasa\Client\Models\Enums\ReceiptPrinterName;

final class EmailRegisterReceiptPrintContextDto extends RegisterReceiptPrintContextDto {
    /**
     * Nastavenia tlačiarne.
     */
    public EmailReceiptPrinterOptions $options;

    public function __construct(?EmailReceiptPrinterOptions $options = null) {
        $this->options = $options ?? new EmailReceiptPrinterOptions();
        parent::__construct(ReceiptPrinterName::EMAIL);
    }
}
