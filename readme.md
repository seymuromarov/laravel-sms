## About Project

Laravel api for sending sms from different providers  
Currently Supported `Sms.ru` , `Clockwork`  , `MSM`, `Smsapi`
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
SMS_PROVIDER => provider name `msm` , `clockwork` , `smsRu` , `smsApi` ,`nexmo`
SMS_PASS - provider password(key on `clockwork`, api_id on `smsRu`,MD5password on `smsApi`)  
SMS_FROM - from optional for some providers
SMS_USER - Username optional for some providers 
 
Note for `Nexmo` :api_key is SMS_PASS, api_secret is SMS_USER

For using Sms Sender use this:
```
    Sms::send($number,$message);
    Sms::send(441234567890,"HELLO WORLD");
    Sms::send([441234567890,994515553344,441234567891],"HELLO WORLD");

```
  
for checking balance use (only for Clockwork,SmsApi):  
```
    Sms::balance();
```