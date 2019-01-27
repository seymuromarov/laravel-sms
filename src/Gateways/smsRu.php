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

class SmsRu
{
    public function send_sms($mobile, $content)
    {
        if (is_array($mobile)) {
            $mobile = implode(',', $mobile);
        }
        $url = config('sms-package.smsRu_url') . "?api_id=" . config('sms-package.pass') . "&to=" . $mobile . "&msg=" . $content . "&json=1";
        $client = new Client();

        $request = new \GuzzleHttp\Psr7\Request('GET', $url);
        $promise = $client->sendAsync($request)->then(function ($response) {
            return $response->getBody();
        });
        $promise->wait();
    }
}