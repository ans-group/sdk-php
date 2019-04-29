UKFast API PHP client
=====================

# Currently in beta

SDK is still in development but will be fully released shortly. It's unlikely that the interface will change significantly, but it's possible that some breaking changes will be made.

A PHP client library for connecting your application(s) to the UKFast APIs. 

To use this package, you will need a UKFast account. Sign up for free at [ukfast.co.uk][1], 
and refer to the [Getting Started][2] section of our developer documentation for more information on consuming our APIs.


Installation
------------

The recommended way to install this package is through [composer](https://getcomposer.org).

```
composer require ukfast/client
```

This package does currently support PHP 5.6+, but we recommend moving to 7.1+ as soon as possible. 


Usage
-----

Each API has its own client class that extends from a base client class. All clients have an `auth` method which takes an API token to be used when sending requests.

**Example**

```php
<?php

$client = (new \UKFast\Pss\Client)->auth('API KEY');

$page = $client->getRequests();

foreach ($page->getItems() as $request) {
    echo "#{$request->id} - {$request->subject}\n";
}
```


Contributing
------------

We welcome contributions that will benefit our users, 
please see [CONTRIBUTING](CONTRIBUTING.md) for details on how to get involved.


License
-------

This SDK is released under the [MIT License][license]


[1]: https://www.ukfast.co.uk/myukfast-signup.html??utm_source=github&utm_medium=link&utm_campaign=apio
[2]: https://developers.ukfast.io/getting-started?utm_source=github&utm_medium=link&utm_campaign=apio
