<?php

namespace NineDigit\eKasa\Client\Models\Traits;

trait ReceiptPaymentTrait
{
    /**
     * Názov platidla v dĺžke 1 až 255 znakov
     * @example Hotovosť
     * @var string
     */
    public string $name;

    /**
     * Celková suma v EUR.
     * Číslo v rozsahu -10000000 až 10000000 s presnosťou na dve desatinné miesta.
     * @example 15.00
     * @var float
     */
    public float $amount;
}
