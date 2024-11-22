<?php

namespace NineDigit\eKasa\Client\Models\Traits;

use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptDto;

trait RegisterReceiptRequestTrait
{
    /**
     * Externý unikátny identifikátor požiadavky.
     * Neprázdny reťazec s maximálnou dĺžkou 40 znakov.
     * @example e52ff4d1-f2ed-4493-9e9a-a73739b1ba17
     */
    public ?string $externalId;

    /**
     * Doklad.
     */
    public ReceiptDto $data;
}
