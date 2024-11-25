<?php

namespace NineDigit\eKasa\Client\Models\Enums;

/**
 * Typ položky dokladu.
 */
enum ReceiptItemType: string {

    /**
     * Kladná (Kladná položka) - suma položky za predaj tovaru alebo poskytnutie služby.
     */
    case POSITIVE =  'Positive';

    /**
     * Vrátené obaly (Záporná položka) - suma položky za vykúpené zálohované obaly.
     */
    case RETURNED_CONTAINER =  'ReturnedContainer';

    /**
     * Vrátená (Záporná položka) - zrušenie evidovanej položky po jej vystavení na pokladničnom
     * doklade pri vrátení tovaru alebo služby.
     */
    case RETURNED =  'Returned';

    /**
     * Opravná (Kladná alebo záporná položka) - negácia položky už zaevidovaného dokladu
     * v systéme e-kasa v prípade jej opravy.
     */
    case CORRECTION =  'Correction';

    /**
     * Zľava (Záporná položka) – suma poskytnutých zliav.
     */
    case DISCOUNT =  'Discount';

    /**
     * Odpočítaná záloha (Záporná položka) – suma prijatého preddavku uvedená na doklade
     * vystavenom v čase úhrady doplatku ceny za predaný tovar alebo poskytnutú službu.
     */
    case ADVANCE =  'Advance';

    /**
     * Výmena poukazu (Záporná položka) – suma jednoúčelového poukazu pri jeho výmene za tovar
     * alebo poskytnutú službu.
     */
    case VOUCHER =  'Voucher';
}
