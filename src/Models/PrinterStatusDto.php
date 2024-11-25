<?php

namespace NineDigit\eKasa\Client\Models;

use NineDigit\eKasa\Client\Models\Enums\PrinterPaperState;
use NineDigit\eKasa\Client\Models\Enums\PrinterState;

final class PrinterStatusDto
{
    public PrinterState $state;

    public ?PrinterPaperState $paperState;
}
