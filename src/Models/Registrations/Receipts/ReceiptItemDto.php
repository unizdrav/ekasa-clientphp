<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

use NineDigit\eKasa\Client\Models\QuantityDto;
use NineDigit\eKasa\Client\Models\SellerDto;
use NineDigit\eKasa\Client\Models\Traits\ReceiptItemTrait;
use NineDigit\eKasa\Client\Models\Enums\ReceiptItemType;

final class ReceiptItemDto {

    use ReceiptItemTrait;

    public function __construct(
        ReceiptItemType $type = ReceiptItemType::POSITIVE,
        string $name = "",
        float $unitPrice = 0,
        ?float $vatRate = 0,
        ?QuantityDto $quantity = null,
        float $price = 0,
        ?string $description = null,
        ?SellerDto $seller = null,
        ?string $taxFreeReason = null,
        ?string $voucherNumber = null,
        ?string $referenceReceiptId = null
    ) {
        $this->type = $type;
        $this->name = $name;
        $this->unitPrice = $unitPrice;
        $this->vatRate = $vatRate;
        $this->quantity = $quantity ?? new QuantityDto();
        $this->price = $price;
        $this->description = $description;
        $this->seller = $seller;
        $this->specialRegulation = $taxFreeReason;
        $this->voucherNumber = $voucherNumber;
        $this->referenceReceiptId = $referenceReceiptId;
    }
}
