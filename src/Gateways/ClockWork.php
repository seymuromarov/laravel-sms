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

class Clockwork
{
    public function send_sms($mobile, $content)
    {
        if (is_array($mobile)) {
            $mobile = implode(',', $mobile);
        }
        $url = config('sms-package.clockwork_url') . "?key=" . config('sms-package.pass') . "&to=" . $mobile . "&content=" . $content;
        $client = new Client();

        $request = new \GuzzleHttp\Psr7\Request('GET', $url);
        $promise = $client->sendAsync($request)->then(function ($response) {
            return 'Result: ' . $response->getBody();
        });
        $promise->wait();
    }

    public function balance()
    {
        $url = "http://api.clockworksms.com/http/balance?key=" . config('sms-package.pass');
        $client = new Client();
        $request = new \GuzzleHttp\Psr7\Request('GET', $url);
        $promise = $client->sendAsync($request)->then(function ($response) {
            return $response->getBody();
        });
        $promise->wait();
    }

}