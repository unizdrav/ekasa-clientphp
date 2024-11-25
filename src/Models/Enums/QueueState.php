<?php

namespace NineDigit\eKasa\Client\Models\Enums;
enum QueueState: string {
    case Created =  'Created';
    case Initializing =  'Initializing';
    case InitializeFailed =  'InitializeFailed';
    case Initialized =  'Initialized';
    case Processing =  'Processing';
    case ProcessFailed =  'ProcessFailed';
    case Processed =  'Processed';
    case Canceled =  'Canceled';
    case Faulted =  'Faulted';
}
