<?php

namespace NineDigit\eKasa\Client\Models;


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

    public string $state;
}
