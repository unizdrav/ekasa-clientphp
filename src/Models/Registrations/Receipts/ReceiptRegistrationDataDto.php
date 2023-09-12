<?php

namespace NineDigit\eKasa\Client\Models\Registrations\Receipts;

use DateTime;

final class ReceiptRegistrationDataDto extends RegistrationDataDto
{
    /**
     * Typ pokladničného dokladu.
     * @see ReceiptType
     * @example CashRegister
     */
    public string $receiptType;
    /**
     * Celková suma v EUR
     */
    public float $amount;
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
    public float $roundingAmount;
    /**
     * Dátum a čas vyhotovenia dokladu alebo paragónu podnikateľom.
     * V prípade paragónu je to dátum a čas vyhotovenia paragónu.
     * Vo väčšine prípadov je tento dátum rovnaký ako dátum vytvorenia
     * dokladu v ORP.
     */
    public ?DateTime $issueDate;
    /**
     * Poradové číslo dokladu.
     * Pri požiadavke aj odpovedi k registrácií dokladu nadobúda rovnakú
     * hodnotu.
     */
    public ?int $receiptNumber;
    /**
     * Poradové číslo faktúry, ak ide o úhradu faktúry alebo jej časti.
     */
    public ?string $invoiceNumber;
    /**
     * Poradové číslo paragónu.
     */
    public ?int $paragonNumber;
    /**
     * Identifikačné číslo pre daň z pridanej hodnoty, ak podnikateľ
     * je platiteľom dane z pridanej hodnoty.
     */
    public ?string $icdph;
    /**
     * Identifikačné číslo organizácie podnikateľa.
     */
    public ?string $ico;
    /**
     * Celková suma DPH pre základnú sadzbu dane podľa zákona
     * č. 222/2004 Z.z.
     */
    public ?float $basicVatAmount;
    /**
     * Celková suma DPH pre zníženú sadzbu dane podľa zákona
     * č. 222/2004 Z.z.
     */
    public ?float $reducedVatAmount;
    /**
     * Celková suma oslobodená od DPH.
     */
    public ?float $taxFreeAmount;
    /**
     * Celková suma základu DPH pre základnú sadzbu dane podľa
     * zákona č. 222/2004 Z.z.
     */
    public ?float $taxBaseBasic;
    /**
     * Celková suma základu DPH pre zníženú sadzbu dane podľa
     * zákona č. 222/2004 Z.z.
     */
    public ?float $taxBaseReduced;
    /**
     * Položky dokladu.
     * @var ReceiptItemDto[]
     */
    public ?array $items;
    /**
     * Overovací kód podnikateľa.
     */
    public ?string $okp;
    /**
     * Podpisový kód podnikateľa.
     */
    public ?string $pkp;
    /**
     * Platidlá.
     * @var ReceiptPaymentDto[]
     */
    public ?array $payments;
    /**
     * Textová hlavička dokladu.
     */
    public ?string $headerText;
    /**
     * Textová pätička dokladu.
     */
    public ?string $footerText;
}