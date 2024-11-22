<?php

namespace NineDigit\eKasa\Client\Models;

final class IdentityPhysicalAddressDto
{
    public string $country;
    public string $streetName;
    public ?string $municipality;
    public ?string $buildingNumber;

    public ?string $propertyRegistrationNumber;

    public IdentityDeliveryAddressDto $deliveryAddress;
}
