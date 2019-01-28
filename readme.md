## About Project

Laravel api for sending sms from different providers and auth via sms  
Currently Supported `Sms.ru` , `Clockwork`  , `MSM`, `Smsapi`,`Nexmo`, `Clickatell`
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

Add following values to your `.env`
```
SMS_USER=
SMS_PASS=
SMS_FROM=
SMS_PROVIDER=
```
SMS_PROVIDER => provider name `msm` , `clockwork` , `smsRu` , `smsApi` ,`nexmo`,`clickatell`
SMS_PASS - provider password(key on `clockwork`,apiKey on `clickatell`, api_id on `smsRu`,MD5password on `smsApi`)  
SMS_FROM - from optional for some providers
SMS_USER - Username optional for some providers 
 
Note for `Nexmo` :api_secret is SMS_PASS, api_key is SMS_USER


use command (optional): 
``` 
php artisan migrate
```
use this command if you want to save sent messages 
or if you want to logging in via sms

optional values to your `.env`
```
SMS_DB=false
```
SMS_DB - if you set true it will log all sent messages on db (you must migrate migrations),default is false

For using Sms Sender use this:
```
    Sms::send($number,$message);
    Sms::send(441234567890,"HELLO WORLD");
    Sms::send([441234567890,994513073940,441234567891],"HELLO WORLD");

```
  
  Note:`Nexmo` does not support bulk message
  
for checking balance use (only for Clockwork,SmsApi):  
```
    Sms::balance();
```



Now supports logging in via sms without password , you can use it for 2FA auth or just simple faster logging in via laravel

If you won't use logging in via sms then u don't need to read from here on

optional .env values

```
SMS_DB_PHONE=phone
```
SMS_DB_PHONE - it is for logging in purpose ,write your phone number column name here (you must set it on users table),default is phone

For example : if you have default users table just add phone_number column on it and change env value like this:
```
SMS_DB_PHONE=phone_number
```

for sending message for login purpose use this

```
    Sms::login_code($number, $message = null, $len = 6);
    Sms::login_code(994513073940, "this is your verification code : "); // it will send message like this  this is your verification code : 254129
    Sms::login_code(994513073940, "use code : ",9); // it will send message like this  this is your verification code : 325475698

```

For verification of code and logging in use this
```
    Sms::check_login($number, $code, $id = null);
    Sms::login_code(994513073940, "254129"); // it will find user and login with user whose number is 994513073940 and login via phone number

   // If u don't have phone table on users , we have solution for this too , just send id which u want to login for example:
   Sms::login_code(994513073940, "254129",24); // it will find user whose id is 24 and login via id 

```

it will return true if logged in successful, false if there was a problem 
