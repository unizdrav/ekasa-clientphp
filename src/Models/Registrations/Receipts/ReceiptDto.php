<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

/*
 * Doklad
 */

use NineDigit\eKasa\Client\Models\Traits\ReceiptTrait;

final class ReceiptDto extends RegistrationRequestDataDto {

    use ReceiptTrait;

    public function __construct(
        string $receiptType = ReceiptType::CASH_REGISTER,
        string $cashRegisterCode = "",
        ?array $items = null,
        ?array $payments = null
    ) {
        $this->receiptType = $receiptType;
        $this->cashRegisterCode = $cashRegisterCode;
        $this->items = $items;
        $this->payments = $payments;
    }
}
