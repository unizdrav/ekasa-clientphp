<?php

namespace NineDigit\eKasa\Client\Models;

use NineDigit\eKasa\Client\Models\Enums\ConnectivityState;

final class ConnectivityStatusDto
{
    public \DateTime $requestDate;

    public ConnectivityState $state;
}
