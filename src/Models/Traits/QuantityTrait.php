<?php

namespace NineDigit\eKasa\Client\Models\Traits;

trait QuantityTrait
{
    /**
     * Množstvo predaného tovaru alebo poskytnutej služby s presnosťou na 4 desatinné miesta
     */
    public float $amount;

    /**
     * Množstevná jednotka s dĺžkou 1 až 3 znaky
     */
    public string $unit;
}
