
# e-Kasa Client PHP

HTTP klient v jazyku PHP pre [e-Kasa API riešenie](https://ekasa.ninedigit.sk) spoločnosti [Nine Digit, s.r.o.](https://ninedigit.sk/).

Knižnica je kompatibilná s PHP verzie 7.4 a vyššie.

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