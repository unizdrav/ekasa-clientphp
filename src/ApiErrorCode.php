<?php

namespace NineDigit\eKasa\Client;

/**
 * Kódy chyby vrátený z API
 */
class ApiErrorCode {
    const UNKNOWN = 0;
    const GENERAL_ERROR = -100;
    const CLIENT_LOCKED = -101;
    const INVALID_TIME = -102;
    const INVALID_RECEIPT_NUMBER = -103;
    const RECEIPT_NOT_FOUND = -104;
    const IDENTITY_NOT_FOUND = -201;
    const CERTIFICATE_ERROR = -300;
    const CERTIFICATE_NOT_FOUND = -301;
    const CERTIFICATE_EXPIRED = -302;
    const STORAGE_ERROR = -400;
    const STORAGE_INSUFFICIENT_SPACE = -401;
    const STORAGE_DIC_MISMATCH = -402;
    const STORAGE_DUPLICATE_KEY = -403;
    const PRINTER_ERROR = -500;
    const PRINTER_NOT_FOUND = -501;
    const PRINT_RECEIPT_ERROR = -502;
    const PRINTER_NOT_Ready = -503;
    const VALIDATION_ERROR = -900;
    const OPTIONS_VALIDATION_ERROR = -901;
}