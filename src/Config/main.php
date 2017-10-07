<?php
return [
    'provider' => env('SMS_PROVIDER', 'msm'),
    'from' => env('SMS_FROM', 'from'),
    'user' => env('SMS_USER', 'user'),
    'pass' => env('SMS_PASS', '123456'),
    'msm_url' => "http://api.msm.az/sendsms",
    'clockwork_url' => "http://api.clockworksms.com/http/send.aspx",
    'smsRu_url' => "http://sms.ru/sms/send",
];