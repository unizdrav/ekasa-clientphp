<?php

namespace NineDigit\eKasa\Client\Models;

use NineDigit\eKasa\Client\Models\Traits\QuantityTrait;

/**
 * Množstvo predaného tovaru alebo poskytnutej služby s príslušnou množstevnou jednotkou
 */
final class QuantityDto {

    use QuantityTrait;

    public function __construct(float $amount = 0, string $unit = "x") {
        $this->amount = $amount;
        $this->unit = $unit;
    }
}