<?php

namespace NineDigit\eKasa\Client;

/**
 * e-Kasa prostredie
 */
final class EKasaEnvironment
{
    public const LOCALHOST = "http://localhost:3010/api";

    /**
     * Získa adresu eKasa API servera zastihnuteľnú cez Expose server.
     * Táto funkcionalita vyžaduje aktiváciu danej služby. Pre viac
     * informácií navštívte https://ekasa.ninedigit.sk
     * @param string $subdomain
     * @return string
     */
    public static function exposePlayground(string $subdomain): string
    {
        return "https://$subdomain.expose-int.ninedigit.sk";
    }

    /**
     * Získa adresu eKasa API servera zastihnuteľnú cez Expose server.
     * Táto funkcionalita vyžaduje aktiváciu danej služby. Pre viac
     * informácií navštívte https://ekasa.ninedigit.sk
     * @param string $subdomain
     * @return string
     */
    public static function exposeProduction(string $subdomain): string
    {
        return "https://$subdomain.expose.ninedigit.sk";
    }
}