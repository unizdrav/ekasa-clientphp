<?php

namespace NineDigit\eKasa\Client\Models\Enums;
enum PrinterPaperState: string {
    case Ready =  'Ready';
    case CoverOpen =  'CoverOpen';
    case NearEnd =  'NearEnd';
    case Empty =  'Empty';
}
