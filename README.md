README
======

Installation
------------

Install using Composer:

```
./composer require predanie/bitrix24-monolog-bundle
```

This is updated version. If you whant to use old version, use 0.1 instead

Add the bundle to your AppKernel.php:

``` php
$bundles = array(
    //...
    new Predanie\Bitrix24Bundle\PredanieBitrix24MonologBundle(),
    //...
);
```

And add bitrix24 handler:
``` yml
monolog:
    handlers:
        bitrix24:
            type: service
            id: app.bitrix24_monolog_handler
```

You also can configure it:
``` yml
bitrix24:
    chat_id: 33 # use own chart id
    user_id: 3  # use own user id
    webhook: ABCD_F # create a webhook in the bitrix24 admin panel
```
