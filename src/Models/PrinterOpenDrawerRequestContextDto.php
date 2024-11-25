<?php

namespace NineDigit\eKasa\Client\Models;

use NineDigit\eKasa\Client\Models\Enums\PrinterDrawerPin;

final class PrinterOpenDrawerRequestContextDto
{
    public PrinterDrawerPin $pin;

    public function __construct(PrinterDrawerPin $pin)
    {
        $this->pin = $pin;
    }
}
