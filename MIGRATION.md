# Migrácia medzi verziami

## Prechod z verzie `0.0.7` na `1.0.0`

 - Trieda `EKasaEnvironment` je nahradená triedou `EKasaServer` a bude vymazaná vo verzií *2.0.0*.
 Volanie `EKasaEnvironment::LOCALHOST` je nahradené `EKasaServer::LOCALHOST` a `EKasaEnvironment::exposeProduction($subdomain)` je nahradené `EKasaServer::exposeDefault($subdomain)`. Volanie `EKasaEnvironment::exposePlayground($subdomain)` bude odstránené bez náhrady.
 - 

# Migrácia z knižnice `ekasa-cloud-clientphp` na `ekasa-clientphp`

Projekt *eKasa Cloud* bol nahradený službou *Expose*.

V prípade, ak vo vašom systéme používate PHP knižnicu pre eKasa Cloud ([ekasa-cloud-clientphp](https://github.com/ninedigit/ekasa-cloud-clientphp)) táto sekcia popisuje prechod na knižnicu [ekasa-clientphp](https://github.com/ninedigit/ekasa-clientphp), ktorá plne podporuje komunikáciu so službou *Expose*.


## Zjednodušený proces registrácie dokladu

**Predtým**: Proces registrácie dokladu v eKasa Cloud prebiehal interne v niekoľkých krokoch, ktoré boli reprezentované [stavmi](https://github.com/ninedigit/ekasa-cloud/wiki/receipt-registration) od vytvorenia požiadavky až po jej vybavenie v určenom čase, ktorý bol špecifikovaný v požiadavke (vlastnosť `validityTimeSpan`).

**Teraz**: Výsledok vyhotovenia dokladu prichádza priamo vo forme odpovede na HTTP požiadavku. Výsledkom je finálny stav spracovania požiadavky, prípadne chyba. Kompletne tak odpadá potreba vyhodnocovania jednotlivých stavov požiadavky registrácie.

> **TIP:** Obe knižnice obsahujú v priečinku `examples` vzorové príklady registrácie.
> Pomôžu tak pri migrácii vášho existujúceho kódu.
> 
> - [Príklady](https://github.com/ninedigit/ekasa-cloud-clientphp/tree/master/examples) pre pôvodnú knižnicu `ekasa-cloud-clientphp` 
> - [Príklady](https://github.com/ninedigit/ekasa-clientphp/tree/master/examples) pre novú knižnicu `ekasa-clientphp` 

1. Nastavenia klienta triedou `ApiClientOptions` majú zmenené parametre. Tu je možné určiť spôsob pripojenia k eKasa API a to buď lokálne (`EKasaServer::LOCALHOST`) alebo prostredníctvom Expose služby `EKasaServer::exposeDefault(...)`.
1. Práca s tlačiarňami sa nezmenila, ich prislúchajúce triedy majú však zmenené názvy. Viďte tabuľu nižšie.
1. Trieda položky dokladu má zmenený názov, no jej štruktúra je identická. Pribudla trieda `ReceiptItemBuilder` na pohodlnejšiu tvorbu položiek dokladu.
1. Trieda dokladu má taktiež zmenený názov. Štruktúra je do veľkej miery identická. Vlastnosť `externalId` sa však nastavuje v triede, ktorá zaobaľuje triedu dokladu s externým identifikátorom - `RegisterReceiptRequestDto`. Na vytvorenie objektu dokladu je možné využiť `ReceiptBuilder`.
1. Vytvorený doklad je nutné zabaliť do triedy `RegisterReceiptRequestDto`, kde je možné uviesť externý identifikátor.
1. Požiadavka zaregistrovania dokladu bola premenovaná z `CreateReceiptRegistrationDto` na `RegisterReceiptRequestContextDto` a obsahuje kontext tlačových informácii (viďte bod 1.) a kontextu dokladu (viďte bod 5.). Vypadol teda parameter maximálnej platnosti požiadavky registrácie dokladu (viac informácii je v sekcii [Zmena procesu registrácie dokladu](#zmena-procesu-registrácie-dokladu)).
1. Odoslanie požiadavky registrácie dokladu je rovnakou metódou `registerReceipt`. Tá však skončí buď výsledkom `RegisterReceiptResultDto` (pôvodne `ReceiptRegistrationDto`) prípadne chybou `ValidationProblemDetailsException` resp. `ProblemDetailsException`. Výsledok registrácie je možné pozorovať vo vlastnosti `isSuccessful`, ktorá nadobúda tri stavy: `true` - doklad bol úspešne spracovaný v režíme ON-LINE, `null` - doklad bol úspešne spracovaný v režíme OFF-LINE, `false` - Spracovanie dokladu zlyhalo, pričom informácie o príčine chyby sú uvedené vo vlastnosti `error`.

## Kompletný zoznam zmien

### Zmeny vo výsledku odpovede registrácie dokladu:

| Pôvodná vlastnosť  | Nová vlastnosť     |
| ------------------ | ------------------ |
| `request->receiptType` | `request->data->receiptType` |
| `request->orpCreateDate` | `request->data->createDate` |
| `request->requestId` | `request->id` |
| `request->requestDate` | `request->date` |
| `request->orpProcessDate` | `response->processDate` |
| `request->receiptId` | `response->data->id` |
| `request->eKasaError`| `error` |
| `printer` | *Odstránená* |
| `creationDate` | *Odstránená* |
| `createdBy` | *Odstránená* |
| `notificationDate` | *Odstránená* |
| `validityTimeSpan` | *Odstránená* |
| `acceptationDate` | *Odstránená* |
| `completionTimeSpan` | *Odstránená* |
| `completionDate` | *Odstránená* |
| `state` | *Odstránená* |
| `rejectionReason` | *Odstránená* |
| `error` | *Odstránená (viďte `request->eKasaError`)* |
| `id` | *Odstránená* |
| Ostatné vlastnosti v `request->*` | `request->data->*` |

### Zmeny menných priestorov

| Pôvodný názov  | Nový názov     |
| -------------- | -------------- |
| `NineDigit\eKasa\Cloud\Client` | `NineDigit\eKasa\Client` |
| `NineDigit\eKasa\Cloud\Client\Models` | `NineDigit\eKasa\Client\Models\` |
| `NineDigit\eKasa\Cloud\Client\Models\Registrations\Receipts` | `NineDigit\eKasa\Client\Models\Registrations\Receipts` |

### Zmeny názvov tried

| Pôvodný názov  | Nový názov     |
| -------------- | -------------- |
| `PosReceiptPrinterDto` | `PosRegisterReceiptPrintContextDto` |
| `PdfReceiptPrinterDto` | `PdfRegisterReceiptPrintContextDto` |
| `EmailReceiptPrinterDto` | `EmailRegisterReceiptPrintContextDto` |
| `ReceiptRegistrationItemDto` | `ReceiptItemDto` |
| `ReceiptRegistrationPaymentDto` | `ReceiptPaymentDto` |
| `CreateReceiptRegistrationRequestDto` | `RegisterReceiptRequestDto` |
| `CreateReceiptRegistrationDto` | `RegisterReceiptRequestContextDto` |
| `ReceiptRegistrationDto` | `RegisterReceiptResultDto` |
