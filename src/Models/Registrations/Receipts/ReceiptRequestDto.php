<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

/**
 * Platidlo
 */
final class ReceiptRequestDto
{
    public ReceiptDataRequestDto $data;
    public string $id;
    public string $externalId;
    public string $date;
    public int $sendingCount;
}
