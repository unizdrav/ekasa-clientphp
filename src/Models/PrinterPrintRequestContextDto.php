<?php

namespace NineDigit\eKasa\Client\Models;

final class PrinterPrintRequestContextDto
{
    public string $text;

    public string $cashRegisterCode;

    public function __construct(string $text, string $cashRegisterCode)
    {
        $this->text = $text;
        $this->cashRegisterCode = $cashRegisterCode;
    }
}
