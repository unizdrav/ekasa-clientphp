<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

use NineDigit\eKasa\Client\Models\Traits\RegisterReceiptRequestTrait;

final class RegisterReceiptRequestDto {

    use RegisterReceiptRequestTrait;

    public function __construct(
        ReceiptDto $data,
        string $externalId = null
    ) {
        $this->data = $data;
        $this->externalId = $externalId;
    }
}