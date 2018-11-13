README
======

Installation
------------

Install using Composer:

```
./composer require predanie/bitrix24-monolog-bundle
```

This version was tested with a project based on symfony 3.4.

Add the bundle to your AppKernel.php:

``` php
$bundles = array(
    //...
    new Predanie\Bitrix24Bundle\PredanieBitrix24MonologBundle(),
    //...
);
```

Create a monolog.yml file using current path app/config/bitrix24/monolog.yml and include it to the config_prod.yml file:

```
imports:
    - { resource: bitrix24/monolog.yml }
```
 
Add bitrix24 handler and configure it:

``` yml
monolog:
    handlers:
        bitrix24:
            type: service
            id: predanie.bitrix24_monolog_handler

predanie_bitrix24_monolog:
    chat_id: '%bitrix24_chat_id%'
    user_id: '%bitrix24_user_id%'
    webhook: '%bitrix24_webhook%'
```

Add parameters to your parameters.yml:

``` yml
    bitrix24_chat_id: 1 # your bitrix24 chat for logging
    bitrix24_user_id: 1 # user id who send messages to bitrix24 chat 
    bitrix24_webhook: xxxxxxxxxxxxxx # Weebhook code - need to create in the Bitrix24 admin panel
```
Enjoy!

P.S.: if you need send some custom exceptions just call the bitrix24 manager.

DefaultController.php example:

``` php
    $this->get('predanie.bitrix24_manager')->imMessageAdd($e->getMessage());
```