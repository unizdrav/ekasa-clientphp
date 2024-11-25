<?php

namespace NineDigit\eKasa\Client\Models\Enums;
enum PrinterState: string {
    case Unknown =  'Unknown';
    case Ready =  'Ready';

    case Error =  'Error';
}
