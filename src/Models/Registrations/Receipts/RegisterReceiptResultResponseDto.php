<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

final class RegisterReceiptResultResponseDto extends RegisterResultResponseDto
{
    public ReceiptRegistrationResultReceiptDataDto $data;
}