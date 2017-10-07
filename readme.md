## About Project

Laravel api for sending sms from different providers
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
SMS_PASS - provider password(password on `msm` , key on `clockwork`,
api_id on `sms.ru`)  
SMS_FROM - only for msm   
SMS_USER - only for msm username

For using Sms Sender use this:
```
    Sms::send($number,$message);
    Sms::send(441234567890,"HELLO WORLD");
    Sms::send([441234567890,994515553344,441234567891],"HELLO WORLD");

```
  
for checking balance use (only for Clockwork):  
```
    Sms::balance();
```