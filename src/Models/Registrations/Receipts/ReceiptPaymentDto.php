<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

use NineDigit\eKasa\Client\Models\Traits\ReceiptPaymentTrait;

/**
 * Platidlo
 */
final class ReceiptPaymentDto {

    use ReceiptPaymentTrait;

    public function __construct(float $amount, string $name = ReceiptPaymentName::CASH) {
        $this->amount = $amount;
        $this->name = $name;
    }
}