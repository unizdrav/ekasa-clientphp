
# e-Kasa Client PHP

HTTP klient v jazyku PHP pre [e-Kasa API riešenie](https://ekasa.ninedigit.sk) spoločnosti [Nine Digit, s.r.o.](https://ninedigit.sk/).

Knižnica je kompatibilná s PHP verzie 7.4 a vyššie.

# Migrácia z `ekasa-cloud-clientphp`
Registrácia dokladov s využitím e-Kasa Cloud riešenia za využitia knižnice [ekasa-cloud-clientphp](https://github.com/ninedigit/ekasa-cloud-clientphp) bola nahradená rozšírením Expose, ktoré je integrované priamo v eKasa API.

Služba Expose umožňuje bezpečne zverejniť eKasa API službu na internete prostredníctvom HTTPS protokolu. Tá bude dostupná online prostredníctvom zabepečeného šifrovaného spojenia s ochranou pred neoprávneným prístupom.

Túto knižnicu je možné využiť v dvoch režimoch:
 - priame pripojenie na API v lokálnej sieti
 - pripojenie na API cez Expose server

V oboch prípadoch sa vstupné a výstupné dáta nelíšia, preto je prechod na Expose možný bez úpravy integrácie. Expose teda predstavuje iba transportnú vrstvu medzi integráciou a samotným eKasa API.

## Zmena procesu registrácie dokladu

Registrácia dokladu v eKasa Cloud prebiehala interne v niekoľkých krokoch, ktoré boli definované [stavmi](https://github.com/ninedigit/ekasa-cloud/wiki/receipt-registration) od vytvorenia požiadavky až po jej vybavenie v určenom čase, ktorý bol špecifikovaný v požiadavke (vlastnosť `validityTimeSpan`). Po novom je počas výkonu HTTP požiadavky vyvolaná registrácia dokladu, pričom výsledkom je finálny stav spracovania alebo chyba. Odpadá teda nutnosť vyhodnocovania jednotlivých stavov požiadavky registrácie.

## Zmeny menných priestorov

| Pôvodný názov  | Nový názov     |
| -------------- | -------------- |
| `NineDigit\eKasa\Cloud\Client` | `NineDigit\eKasa\Client` |
| `NineDigit\eKasa\Cloud\Client\Models` | `NineDigit\eKasa\Client\Models\` |
| `NineDigit\eKasa\Cloud\Client\Models\Registrations\Receipts` | `NineDigit\eKasa\Client\Models\Registrations\Receipts` |

## Zmeny názvov tried

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

## Zhrnutie zmien v procese registrácie dokladu

Obe knižnice obsahujú v priečinku `examples` vzorové príklady registrácie a pomôžu tak pri migrácií vášho existujúceho kódu.

1. Nastavenia klienta triedou `ApiClientOptions` majú zmenené parametre. Tu je možné určiť spôsob pripojenia k eKasa API a to buď lokálne (`EKasaEnvironment::LOCALHOST`) alebo prostredníctvom Expose služby (`EKasaEnvironment::exposePlayground(...)` resp. `EKasaEnvironment::exposeProduction(...)`).
2. Práca s tlačiarňami sa nezmenila, ich prislúchajúce triedy majú však zmenené názvy. Viďte tabuľu vyššie.
3. Trieda položky dokladu má zmenený názov, no jej štruktúra je identická. Pribudla trieda `ReceiptItemBuilder` na pohodlnejšiu tvorbu položiek dokladu.
4. Trieda dokladu má taktiež zmenený názov. Štruktúra je do veľkej miery identická. Vlastnosť `externalId` sa však nastavuje v triede, ktorá zaobaľuje triedu dokladu s externým identifikátorom - `RegisterReceiptRequestDto`. Na vytvorenie objektu dokladu je možné využiť `ReceiptBuilder`.
5. Vytvorený doklad je nutné zabaliť do triedy `RegisterReceiptRequestDto`, kde je možné uviesť externý identifikátor.
6. Požiadavka zaregistrovania dokladu bola premenovaná z `CreateReceiptRegistrationDto` na `RegisterReceiptRequestContextDto` a obsahuje kontext tlačových informácií (viďte bod 1.) a kontextu dokladu (viďte bod 5.). Vypadol teda parameter maximálnej platnosti požiadavky registrácie dokladu (viac informácií je v sekcií [Zmena procesu registrácie dokladu](#zmena-procesu-registrácie-dokladu)).
7. Odoslanie požiadavky registrácie dokladu je rovnakou metódou `registerReceipt`. Tá však skončí buď výsledkom `RegisterReceiptResultDto` (pôvodne `ReceiptRegistrationDto`) prípadne chybou `ValidationProblemDetailsException` resp. `ProblemDetailsException`.
Výsledok registrácie je možné pozorovať vo vlastnosti `isSuccessful`, ktorá nadobúda tri stavy:
 - `true`: Doklad bol úspešne spracovaný v režíme ON-LINE
 - `null`: Doklad bol úspešne spracovaný v režíme OFF-LINE
 - `false`: Spracovanie dokladu zlyhalo. Chyba je uvedená vo vlastnosti `error`.

Zmeny vo výsledku odpovede registrácie dokladu:
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

# Vývoj

## Inštalácia Composer-a

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

Inštalácia závislostí knižnice: `php composer.phar install`.

> Po vytvorení nových tried (v separátnych súboroch) je nutné vyvolať `php composer.phar dump-autoload`.

# Testovanie

Pre vykonanie integračných testov je nutné vytvoriť súbor `settings.json` v `tests\integration` vo formáte **JSON** so štruktúrou zhodnou s triedou `ApiClientOptions` a teda:

```json
{
  "url": "https://test.expose.ninedigit.sk",
  "proxyUrl": "192.168.1.218:9090",
  "authentication": {
    "credentials": {
      "userName": "admin",
      "password": "admin"
    },
    "accessToken": {
      "value": "31d6cfe0d16ae931b73c59d7",
      "source": {
        "name": "queryString",
        "keyName": "access_token"
      }
    }
  }
}
```

Testy je možné spustiť príkazom
`./vendor/bin/phpunit --verbose tests`.

Pre spustenie konkrétneho testu je nutné uviesť prepínač `--filter` s názvom testovaciej metódy a teda `./vendor/bin/phpunit --verbose tests --filter testRegisterCashRegisterReceiptUsingPosPrinter`.

## Overenie kompatibility PHP

`./vendor/bin/phpcs --standard=PHPCompatibility --extensions=php --runtime-set testVersion 7.4- ./src`

# Inštalácia

## Packagist
Knižnica je dostupná na https://packagist.org/packages/ninedigit/ekasa-clientphp.

Balík nainštalujete príkazom `composer require ninedigit/ekasa-clientphp`.
Pre inštaláciu špecifickej verzie bude príkaz vyzerať nasledovne `composer require ninedigit/ekasa-clientphp:0.0.1`.

## GitHub
Upravte súbor `composer.json` a pridajte nový repozitár:

```
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/ninedigit/ekasa-clientphp"
    }
  ]
}
```

Následne nainštalujte balík príkazom `composer require ninedigit/ekasa-clientphp`. Pre inštaláciu špecifickej verzie bude príkaz vyzerať nasledovne `composer require ninedigit/ekasa-clientphp:0.0.1`.

> Pre viac informácií navštívte https://getcomposer.org/doc/05-repositories.md#using-private-repositories.

# Expose
EKasa API je štandardne inštalovaná na lokálnom počítači a počúva na adrese http://localhost:3010.
Expose zviditeľní eKasa API službu v sieti internet na zvolenej adrese. Nevyžaduje sa žiadne ďalšie
nastavenie routera ani počítača. Nadviazané spojenie je šifrované a prístup k eKasa API službe je
chránený nastaveným prístupovým kľúčom, ktorý je možné kedykoľvek aktualizovať.

Aktiváciu služby a prihlasovacie údaje je možné vyžiadať zaslaním dopytu na [info@ninedigit.sk](mailto:info@ninedigit.sk).

# Použitie

> Príklady sú dostupné v adresári [examples](https://github.com/ninedigit/ekasa-clientphp/tree/master/examples).

## Zaokrúhľovanie

Výsledky všetkých matematických operácií musia byť pred priradením do príslušných premenných zaokrúhlené a to buď na 6 desatinných miest pre jednotkové ceny (napr. vlastnosť `ReceiptItemDto.unitPrice`) alebo na dve desatinné miesta pre ostatné ceny, prípadne množstvá (napr. vlastnosť `QuantityDto.amount` alebo `ReceiptItemDto.price`).

## Príklad registrácie požiadavky
```php
// Vytvorenie klienta
$clientOptions = new ApiClientOptions(EKasaEnvironment::LOCALHOST);
$client = new ApiClient($clientOptions);

// Nastavenia tlače
$posPrinterOptions = new PosReceiptPrinterOptions();
$posPrinterOptions->openDrawer = true;
$print = new PosRegisterReceiptPrintContextDto($posPrinterOptions);

// Položka
$receiptItem = new ReceiptItemDto(
    ReceiptItemType::POSITIVE, // Kladný typ položky
    "Coca Cola 0.25l", // Názov
    1.29, // Jednotková cena
    20.00, // Daňová hladina
    new QuantityDto(2, "ks"), // Množstvo
    2.58 // Cena
);

// Požiadavka registrácie
$receipt = ReceiptBuilder::cashRegister("88812345678900001", $items)
    ->setHeaderText("Nine Digit, s.r.o.") // Voliteľná hlavička dokladu
    ->setFooterText("Ďakujeme za nákup!") // Voliteľná pätička dokladu
    ->addPayment(new ReceiptPaymentDto(2.60, ReceiptPaymentName::CASH))
    ->addPayment(new ReceiptPaymentDto(-0.02, "Výdavok"))
    ->build();

$request = new RegisterReceiptRequestDto($receipt);
$requestContext = new RegisterReceiptRequestContextDto($print, $request);

// Registrácia
$result = $client->registerReceipt($requestContext);
```