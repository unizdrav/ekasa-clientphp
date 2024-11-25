<?php

namespace NineDigit\eKasa\Client\Models;

use NineDigit\eKasa\Client\Models\Enums\IdentityCashRegisterType;

final class IdentityOrganizationUnitDto
{
    public string $cashRegisterCode;
    public IdentityCashRegisterType $cashRegisterType;
    public bool $hasRegistrationException;
    public ?string $organizationUnitName;

    public IdentityPhysicalAddressDto $physicalAddress;
}
