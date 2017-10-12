<?php
/**
 * Created by PhpStorm.
 * User: omaro
 * Date: 10/7/2017
 * Time: 19:53
 */

namespace Seymuromarov\Sms\Gateways;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class nexmoSms
{
    public function send_sms($mobile, $content)
    {
        if (is_array($mobile)) {
            $mobile = implode(',', $mobile);
        }
        $mobile = explode(",", $mobile);

        $client = new \GuzzleHttp\Client();
        $promise = $client->requestAsync('POST', config('sms-package.nexmo_url'), [
            'form_params' => [
                'from' => config('sms-package.from'),
                'text' => $content,
                'to' => $mobile,
                'api_key' => config('sms-package.user'),
                'api_secret' => config('sms-package.pass'),
            ]
        ])->then(function ($response) {
            echo $response->getBody();
        });
        $promise->wait();

    }
}