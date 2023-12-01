# Príprava integračného prostredia

Táto príručka popisuje inštaláciu a nastavenie eKasa API pre uľahčenie procesu integrácie.

## Inštalácia eKasa API
 - Windows: [MSI](https://ekasa.ninedigit.sk/portos-ekasa-api-setup.latest.msi)
 - MacOS: [x64 (Intel)](https://ekasa.ninedigit.sk/portos-ekasa-api-setup.latest.osx-x64.pkg) / [arm64 (Silicon)](https://ekasa.ninedigit.sk/portos-ekasa-api-setup.latest.osx-arm64.pkg)

Služba **WebAdmin** je po nainštalovaní štandardne dostupná na adrese [`http://localhost:3010`](http://localhost:3010).

## Nastavenie eKasa API

### Výber úložiska a prostredia

Otvorte [**WebAdmin**](http://localhost:3010), prejdite do *Nastavenia* a v prvej záložke *Úložisko* vyberte z poľa *Model úložiska*:
 - typ chráneného dátového úložiska (CDHÚ), ktoré ste fyzicky obdržali na testovacie účely. Vo väčšine prípadov bude táto hodnota **CHDU Lite**.
 - alebo **InMemory**, ak budete testovať na virtuálnom úložisku.

 > **POZOR**: Obsah úložiska typu **InMemory** bude vymazaný po reštartovaní služby eKasa API.

Pred uložením nastavení je ešte potrebné vybrať správne prostredie, v ktorom budú požiadavky registrované. Prejdite do záložky *eKasa klient* a v poli *Prostredie* vyberte možnosť *Integračné* a uložte vykonané zmeny stlačením tlačidla *ULOŽIŤ*.

 > **POZOR**: Staršie verzie *WebAdmin* rozhrania neumožňujú nastaviť úložisko typu **InMemory** a preto je nutné vykonať `POST` požiadavku na `http://localhost:3010/api/v1/settings` s hodnotou `InMemory` pre `storage.storageModel` a `Playground` pre `eKasaClient.environment`.

### Nahratie inicializačného balíčka

> Pozn.: Úložisko typu *InMemory* tento krok nastavenia nevyžaduje, nakoľko je automaticky inicializované s integračnými údajmi.

Pred prvým použitím fyzického CHDÚ je nutné doň nahrať testovací inicializačný balík, ktorý obsahuje identifikačné a autentifikačné údaje vo formáte XML. Tie sú súčasťou [SDK balíčka](https://ekasa.ninedigit.sk/downloads/portos-ekasa-api-sdk.zip) a nachádzajú sa v priečinku `3 - insert XML files via admin application`. Postup pre ich nahratie je v samotnom priečinku alebo vo [Wiki](https://ekasa.ninedigit.sk/wiki/knowledge-base/instalacia-portos-ekasa-sluzby) v sekcií *Vloženie inicializačného balíčka*.

> **DÔLEŽITÉ**: Heslo k uvedeným autentifikačným údajom je **Heslo123**.

Po tomto kroku je všetko pripravené. Stav systému môžete overiť na domovskej obrazovke (*Domov*) WebAdmin rozhrania.

### Inštanciácia klienta

```php
$clientOptions = new ApiClientOptions(EKasaEnvironment::LOCALHOST);
$client = new ApiClient($clientOptions);
```

### Užitočné odkazy
 - Sekcia pre vývojárov: [https://developer.ninedigit.sk/ekasa](https://developer.ninedigit.sk/ekasa)
 - Wiki: [http://ekasa.ninedigit.sk/wiki](http://ekasa.ninedigit.sk/wiki)
 - Dokumentácia k API:
    - [https://developer.ninedigit.sk/ekasa/webapi](https://developer.ninedigit.sk/ekasa/webapi)
    - [http://localhost:3010/docs/index.html](http://localhost:3010/docs/index.html)