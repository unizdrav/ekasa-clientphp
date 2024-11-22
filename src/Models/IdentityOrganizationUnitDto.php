<?php

namespace NineDigit\eKasa\Client\Models;

final class IdentityOrganizationUnitDto
{
    public string $cashRegisterCode;
    public string $cashRegisterType;
    public bool $hasRegistrationException;
    public ?string $organizationUnitName;

    public IdentityPhysicalAddressDto $physicalAddress;
}
