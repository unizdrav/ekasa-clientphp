<?php

namespace NineDigit\eKasa\Client\Models;
use DateTime;

final class CertificateInfoDto {

    /**
     * @var string
     */
    public string $alias;

    /**
     * @var string
     */
    public string $cashRegisterCode;

    /**
     * @var DateTime
     */
    public DateTime $issueDate;

    /**
     * @var DateTime
     */
    public DateTime $expirationDate;

    /**
     * @var string
     */
    public string $serialNumber;

    /**
     * @var bool
     */
    public bool $isExpired;
}
