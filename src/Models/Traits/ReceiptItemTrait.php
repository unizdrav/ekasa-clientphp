<?php

namespace NineDigit\eKasa\Client\Models\Traits;

use NineDigit\eKasa\Client\Models\Enums\ReceiptItemType;
use NineDigit\eKasa\Client\Models\QuantityDto;
use NineDigit\eKasa\Client\Models\SellerDto;

trait ReceiptItemTrait
{
    /**
     * Typ položky dokladu
     * @see ReceiptItemType
     * @example Positive
     * @var ReceiptItemType
     */
    public ReceiptItemType $type;
    /**
     * Označenie tovaru alebo služby.
     * Neprázdny textový reťazec s maximálnou dĺžkou 255 znakov.
     * @example Coca cola
     * @var string
     */
    public string $name;
    /**
     * Celková cena tovaru alebo služby s presnosťou na dve desatinné miesta.
     * Číslo v rozsahu -10000000 až 10000000 s presnosťou na dve desatinné miesta.
     * Celková cena musí byť zhodná s výsledkom vynásobenia jednotkovej ceny a množstva.
     * @example 30.00
     * @var float
     */
    public float $price;
    /**
     * Jednotková cena tovaru alebo služby v EUR s presnosťou na šesť desatinných miest.
     * Číslo v rozsahu -10000000 až 10000000 s presnosťou na šesť desatinných miest.
     * Položka typu Positive musí mať kladnú hodnotu. Položka typu ReturnedContainer,
     * Returned, Discount, Advance, Voucher musí mať zápornú hodnotu.
     * @example 15.00
     * @var float
     */
    public float $unitPrice;
    /**
     * Množstvo tovaru alebo rozsah služby
     * @var QuantityDto
     */
    public QuantityDto $quantity;
    /**
     * Číselná hodnota s presnosťou na 2 desatinné miesta, alebo null pre označenie
     * položky nepodliehajúcej DPH.
     * @link https://ekasa.ninedigit.sk/docs/articles/receipt-registration?tabs=tabid-1#27-vatrate---sadzba-dane-z-pridanej-hodnoty
     * @example 0.00
     * @var float|null
     */
    public ?float $vatRate;
    /**
     * Číslo dokladu, ku ktorému sa vzťahuje oprava alebo vrátenie položky
     * Číslo dokladu ak sa jedná o položku typu Correction alebo Return alebo
     * null v opačnom prípade.
     * V prípade, ak pôvodný doklad obsahuje unikátny identifikátor dokladu,
     * ako referenčné číslo dokladu sa uvedie tento identifikátor. V prípade,
     * ak pôvodný doklad neobsahuje unikátny identifikátor dokladu, ako
     * referenčné číslo dokladu sa uvedie OKP.V prípade pôvodného dokladu
     * vyhotoveného ERP ako referenčné číslo dokladu je uvedené poradové číslo
     * pokladničného dokladu.
     * @example O-7DBCDA8A56EE426DBCDA8A56EE426D1A
     * @var string|null
     */
    public ?string $referenceReceiptId;
    /**
     * Príznak, ktorý bližšie špecifikuje „dôvod“ priradenia dane s hodnotou 0,
     * ak bola položke priradená.
     * Platná hodnota dôvodu priradenia nulovej dane alebo null.
     * Hodnota môže byť uvedená iba pre položky s nulovou sadzbou dane.
     * @example Artwork
     * @var string|null
     */
    public ?string $specialRegulation;
    /**
     * Číslo jednoúčelového poukazu pri jeho výmene za tovar alebo poskytnutú službu.
     * Textový reťazec s dĺžkou 1 až 50 v prípade, že typ položky je Voucher,
     * null v opačnom prípade.
     * @example 201801001
     * @var string|null
     */
    public ?string $voucherNumber;
    /**
     * Predávajúci, v ktorého mene bol predaný tovar alebo poskytnutá služba
     * Predávajúci alebo null, ak nebol uvedený
     * @var SellerDto|null
     */
    public ?SellerDto $seller;
    /**
     * Nepovinný dodatočný popis položky dokladu, vyobrazený na doklade.
     * @var string|null
     */
    public ?string $description;
}
