<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

/**
 * Platidlo
 */
final class ReceiptsRequestDto
{
    public ReceiptRequestDto $request;
    public ReceiptResponseDto $response;
    public bool $isSuccessful;
    public ?string $error = null;
    public string $type;
}
