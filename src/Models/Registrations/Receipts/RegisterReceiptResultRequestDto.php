<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

final class RegisterReceiptResultRequestDto extends RegisterResultRequestDto {
    /**
     * @var ReceiptregistrationDataDto
     */
    public ReceiptregistrationDataDto $data;
}