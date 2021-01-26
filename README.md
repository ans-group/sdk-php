UKFast API PHP SDK
=====================
[![Build Status](https://travis-ci.org/ukfast/sdk-php.svg?branch=master)](https://travis-ci.org/ukfast/sdk-php)
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)


A PHP library for connecting your application(s) to the UKFast APIs. 

To use this package, you will need a UKFast account. Sign up for free at [ukfast.co.uk][1], 
and refer to the [Getting Started][2] section of our developer documentation for more information on consuming our APIs.


Installation
------------

The recommended way to install this package is through [composer](https://getcomposer.org).

```
composer require ukfast/sdk
```

Alternativly you can download one of our [tagged releases](https://github.com/ukfast/sdk-php/releases) for manual installation, we dont recommend cloning the master branch for use in production environments as we cannot guarentee its stability.

This package does currently support PHP 5.6+, but we recommend moving to 7.1+ as soon as possible. 


Usage
-----

Each API has its own client class that extends from a base client class. All clients have an `auth` method which takes an API token to be used when sending requests.

Each client class has its own subclients, which can be accessed via methods on the base client.

**Example**

```php
<?php

$client = (new \UKFast\SDK\PSS\Client)->auth('API KEY');

$page = $client->requests()->getPage();

foreach ($page->getItems() as $request) {
    echo "#{$request->id} - {$request->subject}\n";
}
```


Contributing
------------

We welcome contributions that will benefit other users, 
please see [CONTRIBUTING](CONTRIBUTING.md) for details on how you can get involved.


License
-------

This SDK is released under the [MIT License](LICENSE)


[1]: https://www.ukfast.co.uk/myukfast-signup.html??utm_source=github&utm_medium=link&utm_campaign=apio
[2]: https://developers.ukfast.io/getting-started?utm_source=github&utm_medium=link&utm_campaign=apio
