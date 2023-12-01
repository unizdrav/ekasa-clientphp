# Changelog

Všetky významné zmeny v projekte budú uvedené v tomto dokumente.

Formát dokumentu vychádza z [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
a dodržiava [sémantické verzionovanie](https://semver.org/spec/v2.0.0.html).

## [0.0.1] - 2023-09-12
 - Prvá verzia knižnice

## [0.0.2] - 2023-10-24
 - Aktualizovaný README.md dokument.
 - Pridaná `debug` vlastnosť do triedy `ApiClientOptions`.
 - Opravená kompozícia dokladu triedou `ReceiptBuilder`.
 - Migrácia na `Guzzle@^7.0`.

## [0.0.3] - 2023-11-13
 - Oprava chyby, kedy klient vytvoril nesprávu URL adresu pre integračné/produkčné prostredie.
 - Aktualizované README.md a INTEGRATOR.md dokumenty.
 - Vytvorená migračná príručka MIGRATION.md.

## [0.0.4] - 2023-11-13
 - Oprava chyby, kedy vlastnosti triedy `ApiResponseMessage` neboli nastavené.
 - Vylepšené vyhodnocovanie odopovede zo servera.

## [0.0.5] - 2023-11-20
 - Vylepšené vyhodnocovanie odopovede zo servera.

## [0.0.6] - 2023-11-21
 - Vylepšené vyhodnocovanie odopovede zo servera.
 - Vytvorená nová trieda výnimky `ExposeException` pre chyby *Expose* služby.
 - Vytvorená nová trieda výnimky `ResponseException`. Tá je základným typom pre triedy `ApiException` (výnimka pre chyby *eKasa API* služby) a `ExposeException`.
 - Vytvorená nová trieda `ExposeError`. Tá obsahuje identifikátor chyby *Expose* služby.

## [0.0.7] - 2023-12-01
 - Doplnené typové anotácie `@var` na vlastnosti deserializovaných modelov
 - Opravené chyby v dokumentačných súboroch *INTEGRATOR.md* a *README.md*