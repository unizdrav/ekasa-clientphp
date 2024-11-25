<?php

namespace NineDigit\eKasa\Client\Models\Enums;

/**
 * Typ dokladu
 */
enum ReceiptType: string {

    /**
     * Pokladničný doklad
     */
    case CASH_REGISTER =  'CashRegister';

    /**
     * Neplatný doklad
     */
    case INVALID =  'Invalid';

    /**
     * Paragón
     */
    case PARAGON =  'Paragon';

    /**
     * Úhrada faktúry
     */
    case INVOICE =  'Invoice';

    /**
     * Paragón pri úhrade faktúry
     */
    case INVOICE_PARAGON =  'InvoiceParagon';

    /**
     * Doklad označený slovom „Vklad“
     */
    case DEPOSIT =  'Deposit';

    /**
     * Doklad označený slovom „Výber“
     */
    case WITHDRAW =  'Withdraw';
}
