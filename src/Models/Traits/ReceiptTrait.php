<?php

namespace NineDigit\eKasa\Client\Models\Traits;

use NineDigit\eKasa\Client\Models\Enums\ReceiptType;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptItemDto;
use NineDigit\eKasa\Client\Models\Registrations\Receipts\ReceiptPaymentDto;
use DateTime;

trait ReceiptTrait
{
    /**
     * Typ pokladničného dokladu.
     * @see ReceiptType
     * @example CashRegister
     */
    public ReceiptType $receiptType;

    /**
     * Dátum a čas vyhotovenia dokladu typu Paragon alebo InvoiceParagon.
     * Serializovaná hodnota musí byť typu reťazec v štandarde ISO 8601.
     */
    public ?DateTime $issueDate;

    /**
     * Číslo faktúry.
     * Neprázdny textový reťazec s maximálnou dĺžkou 50 znakov, pre dokad typu Invoice
     * alebo InvoiceParagon, inak null.
     * @example 201801001
     */
    public ?string $invoiceNumber;

    /**
     * Číslo paragónu.
     * Číslo v rozsahu 1 až 4294967295 pre doklad typu Paragon, inak null.
     */
    public ?int $paragonNumber;

    /**
     * Položky dokladu.
     * Neprázdny zoznam položiek dokladu s maximálnym počtom 500 pre doklad typu
     * CashRegister, Paragon alebo Invalid, inak null.
     * Ak zoznam obsahuje zľavnené položky, ich celková suma musí byť nižšia alebo rovná
     * sume kladných položiek. Ak zoznam obsahuje kupóny, musia byť v rovnakej sadzbe
     * DPH, ako zaevidované položky, ku ktorým sa kupóny vzťahujú.
     * @var ?ReceiptItemDto[]
     */
    public ?array $items;

    /**
     * Zoznam platidiel.
     * Zoznam platidiel, ktorého suma hodnôt každého platidla musí byť vyššia alebo rovná
     * sume cien všetkých položiek dokladu.
     * @var ?ReceiptPaymentDto[]
     */
    public ?array $payments;

    /**
     * Celková suma v EUR.
     * Číslo v rozsahu -10000000 až 10000000 s presnosťou na dve desatinné miesta pre
     * doklad typu Invoice, InvoiceParagon, Deposit alebo Withdraw, inak null.
     */
    public ?float $amount;

    /**
     * Výška zaokrúhlenia.
     *
     * Číslo v rozsahu -0.04 až 0.04 s presnosťou na dve desatinné miesta.
     *
     * Cena platená v hotovosti sa zaokrúhľuje na 5 eurocentov. Celkový zvyšok nezaokrúhlenej ceny
     * platenej v hotovosti, ktorý je nižší ako polovica hodnoty 5 eurocentov, sa zaokrúhľuje nadol
     * a celkový zvyšok nezaokrúhlenej ceny platenej v hotovosti, ktorý je rovný alebo vyšší
     * ako polovica hodnoty 5 eurocentov, sa zaokrúhľuje nahor. Ak je cena platená v hotovosti
     * súčtom cien za viac kusov toho istého tovaru alebo viac kusov rôznych tovarov, zaokrúhľuje
     * sa takto až výsledná cena platená v hotovosti. Cena platená v hotovosti vo výške 1 eurocent
     * alebo 2 eurocenty sa zaokrúhľuje na 5 eurocentov.
     * @example 0.04
     */
    public ?float $roundingAmount;

    /**
     * Textová hlavička dokladu.
     * Textový reťazec, ktorý nesmie obsahovať kontrolné znaky, okrem znakov CR a LF.
     */
    public ?string $headerText;

    /**
     * Textová pätička dokladu.
     * Textový reťazec, ktorý nesmie obsahovať kontrolné znaky, okrem znakov CR a LF.
     */
    public ?string $footerText;
}
