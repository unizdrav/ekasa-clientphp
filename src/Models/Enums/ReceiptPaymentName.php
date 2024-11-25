<?php

namespace NineDigit\eKasa\Client\Models\Enums;
enum ReceiptPaymentName: string {
    case CASH =  'Hotovosť';
    case EXPENSE = 'Výdavok';
}
