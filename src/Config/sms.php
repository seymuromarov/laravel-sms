<?php
return [
    'provider' => env('SMS_PROVIDER', 'msm'),
    'from' => env('SMS_FROM', 'from'),
    'user' => env('SMS_USER', 'user'),
    'pass' => env('SMS_PASS', '123456'),
    'onetime' => env('SMS_ONETIME', false),
    'db' => env('SMS_DB', false),
    'db_phone' => env('SMS_DB_PHONE', "phone"),
    'msm_url' => "https://api.msm.az/sendsms",
    'clockwork_url' => "https://api.clockworksms.com/http/send.aspx",
    'smsRu_url' => "https://sms.ru/sms/send",
    'smsApi_url' => "https://api.smsapi.com/sms.do?format=json",
    'nexmo_url' => "https://rest.nexmo.com/sms/json",
    'clickatell_url' => "https://platform.clickatell.com/messages/http/send",
];