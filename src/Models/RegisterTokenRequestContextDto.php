<?php

namespace NineDigit\eKasa\Client\Models;

final class RegisterTokenRequestContextDto
{
    public string $type;

    public ?string $id;

    public ?string $externalId;

    public ?string $uuid;

    public ?string $originUUID;

    public \DateTime $createDate;

    public ?string $cashRegisterCode;

    public ?int $receiptNumber;

    public int $sendingCount;
}
