<?php

namespace NineDigit\eKasa\Client\Models;

final class IdentityDto
{
    public string $dic;
    public ?string $ico;
    public ?string $icdph;
    public string $corporateBodyFullName;
    public IdentityOrganizationUnitDto $organizationUnit;
    public IdentityPhysicalAddressDto $physicalAddress;
}
