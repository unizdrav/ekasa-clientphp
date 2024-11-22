<?php

namespace NineDigit\eKasa\Client\Models;

final class PrinterOpenDrawerRequestContextDto
{
    public string $pin;

    public function __construct(string $pin)
    {
        $this->pin = $pin;
    }
}
