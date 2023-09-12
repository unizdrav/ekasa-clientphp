<?php

namespace NineDigit\eKasa\Client\Models\Registrations;

final class EKasaErrorDto {
    /**
     * Chybová správa zo systému e-Kasa.
     */
    public string $message;
    /**
     * Kód chybovej správy zo systému e-Kasa.
     */
    public ?int $code;
}