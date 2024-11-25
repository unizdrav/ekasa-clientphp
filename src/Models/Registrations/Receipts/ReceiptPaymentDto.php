<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

use NineDigit\eKasa\Client\Models\Traits\ReceiptPaymentTrait;
use NineDigit\eKasa\Client\Models\Enums\ReceiptPaymentName;

/**
 * Platidlo
 */
final class ReceiptPaymentDto {

    use ReceiptPaymentTrait;

    public function __construct(float $amount, ReceiptPaymentName $name = ReceiptPaymentName::CASH) {
        $this->amount = $amount;
        $this->name = $name;
    }
}
