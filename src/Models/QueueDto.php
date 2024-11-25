<?php

namespace NineDigit\eKasa\Client\Models;


use NineDigit\eKasa\Client\Models\Enums\QueueState;

final class QueueDto {

    /**
     * @var RegisterTokenRequestContextDto
     */
    public RegisterTokenRequestContextDto $requestContext;

    /**
     * @var RegisterTokenResultDto
     */
    public RegisterTokenResultDto $result;

    /**
     * @var RegisterTokenErrorDto
     */
    public RegisterTokenErrorDto $error;

    public QueueState $state;
}
