<?php

namespace NineDigit\eKasa\Client\Models\Enums;
enum ReceiptPrinterName: string {

    /**
     * Označuje názov tlačiarne papierových dokladov.
     */
    case POS =  'pos';

    /**
     * Označuje názov tlačiarne vyhotovujúci PDF súbory.
     */
    case PDF =  'pdf';

    /**
     * Označuje názov tlačiarne vyhotuvujúci emailové správy.
     */
    case EMAIL =  'email';
}
