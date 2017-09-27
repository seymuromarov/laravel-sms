<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

## About Project

Laravel api for sending messages and checking balance with ClockWorkSms 

## Requirements

* [Composer](https://getcomposer.org/)
* [Laravel](https://laravel.com/)
* [Guzzle](https://github.com/guzzle/guzzle)

## Installation

Require package:
``` bash
composer require seymuromarov/sms
```

Now add the service provider in config/app.php file:
```  
'providers' => [
    // ...
        Seymuromarov\Sms\SmsServiceProvider::class,
],
```

after this add alias in config/app.php file:

``` 
'aliases' => [
 //...
        'Sms' => Seymuromarov\Sms\Facades\Sms::class
 ],
```

use command (optional): 
``` 
composer dump-autoload
```

Add following values to your `.env`
```
SMS_USER=
SMS_PASS=
SMS_FROM=
SMS_PROVIDER=
```
SMS_PROVIDER => provider name `msm` , `clockwork`  
SMS_PASS - provider password(password on `msm` , key on `clockwork`)  
SMS_FROM - only for msm   
SMS_USER - only for msm username

For using `xml` Interface use this:
```
    Sms::send($number,$message);
    Sms::send(441234567890,"HELLO WORLD");
    Sms::send([441234567890,994515553344,441234567891],"HELLO WORLD");

```

For using `http` Interface use this:
```
    Sms::sendHTTP($number,$message);
    Sms::sendHTTP(441234567890,"HELLO WORLD");
    Sms::sendHTTP([441234567890,994515553344,441234567891],"HELLO WORLD");

```
NOTE:`msm` does not provide bulk message on http api use xml instead of it  
  
for checking balance use (only for Clockwork):  
```
    Sms::balance();
```