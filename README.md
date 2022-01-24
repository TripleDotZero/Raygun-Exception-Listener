Raygun Data Filter
=================
This package lets you add filters to the Raygun package (which this package is dependent on). By using this package you filter the data that is being send to Raygun in order to comply to the GDPR Law. You can also add/overwrite the filters to better suit your application.

##Installation
Raygun Data Filter is dependent on Raygun4PHP, in order to use Raygun Data Filter make sure the [Raygun4PHP](http://raygun.com) package is working correctly

### With Composer
Composer is a package management tool for PHP which automatically fetches dependencies and also supports autoloading - this is a low-impact way to get Raygun4PHP into your site.

1\. If you use a *nix environment, follow the instructions to install Composer. Windows users can run this installer to automatically add it to the Path.

2\. Within the project's root directory run the following console command:
```console
php composer.phar require tripledotzero/raygun-exception-listener
```

3\. From your shell run php composer.phar install (*nix) or composer install (Windows). This will download Raygun4PHP and create the appropriate autoload data.

##Usage
You can automatically send both PHP errors and object-oriented exceptions to Raygun. The RaygunClient requires an HTTP transport (e.g. Guzzle or other PSR-7 compatible interface).

Currently, there are 2 Guzzle-based transport classes. asynchronous and synchronous. You can choose to use either the GuzzleSync or GuzzleAsync by setting `setUseAsync` to `true`.

###example code
```php
<?php

namespace App\EventListener;

use RaygunFilterParams\Config;
use RaygunFilterParams\DataFilter;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $config = new Config($_ENV['RAYGUN_BASE_URI'], $_ENV['RAYGUN_API_KEY']);
        $config->setUserTracking(true);
        $dataFilter = new DataFilter($config);
        $dataFilter->sendToRaygun($event->getThrowable());
    }
}

```
as you can see in order to send the data to Raygun, you would first need to create the config object with the BASE_URI and API_KEY.
The `DisableUserTracking` is turn off by default, in order to turn it on use
```php 
$config->setUserTracking(true);
```
it is the same for the proxy
```php 
$config->setProxy('proxy:8080');
```

For more information see the Raygun4PHP [documentation](https://github.com/MindscapeHQ/raygun4php) or the [Raygun website](https://raygun.com/documentation/)
