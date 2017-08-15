REST API SDK for PHP
====================
[![Build Status](https://travis-ci.org/paypal/rest-api-sdk-php.png?branch=master)](https://travis-ci.org/paypal/rest-api-sdk-php) [![Coverage Status](https://coveralls.io/repos/paypal/rest-api-sdk-php/badge.png?branch=master)](https://coveralls.io/r/paypal/rest-api-sdk-php?branch=master) [![Latest Stable Version](https://poser.pugx.org/paypal/rest-api-sdk-php/v/stable.png)](https://packagist.org/packages/paypal/rest-api-sdk-php) [![Total Downloads](https://poser.pugx.org/paypal/rest-api-sdk-php/downloads.png)](https://packagist.org/packages/paypal/rest-api-sdk-php)

This repository contains PayPal's PHP SDK and samples for REST API.


Prerequisites
-------------

   * PHP 5.3 or above
   * curl, json & openssl extensions must be enabled
   * composer for running the sample out of the box (See http://getcomposer.org)


Running the sample
------------------

   * Ensure that you have composer installed on your machine.
   * Navigate to the samples folder and run 'composer update'.
   * Optionally, update the bootstrap.php file with your own client Id and client secret.
   * Run any of the samples in the 'samples' folder to see what the APIs can do.
    
    
Usage
-----

To write an app that uses the SDK 

   * Copy the composer.json file from the sample folder over to your project and run 'composer update' to fetch all 
dependencies
   * Copy the sample configuration file sdk_config.ini to a location of your choice and let the SDK know your config path using the following define directive
    
```php
    define('PP_CONFIG_PATH', /path/to/your/sdk_config.ini);
```
    
   * Obtain your clientId and client secret from the developer portal. You will use them to create a `OAuthTokenCredential` object.
   * Now you are all set to make your first API call. Create a resource object as per your need and call the relevant operation or invoke one of the static methods on your resource class.
    
```php

    $apiContext = new ApiContext(new OAuthTokenCredential('<clientId>', '<clientSecret'));
		
    $payment = new Payment();

    $payment->setIntent("Sale");

    ...

    $payment->create($apiContext);

      *OR*

    $payment = Payment::get('payment_id', $apiContext);
```

These examples pick the SDK configuration from the sdk_config.ini file. If you do not want to use an ini file or want to pick your configuration dynamically, you can use the `$apiContext->setConfig()` method to pass in the configuration.
	

Contributing
------------

More help
---------

   * [API Reference](https://developer.paypal.com/webapps/developer/docs/api/)
   * [Reporting issues / feature requests] (https://github.com/paypal/rest-api-sdk-php/issues)