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

class Clickatell
{
    public function send_sms($mobile, $content)
    {
        if (is_array($mobile)) {
            $mobile = implode(',', $mobile);
        }
        $url = config('sms-package.clickatell_url') . "?apiKey=" . config('sms-package.pass') . "&to=" . $mobile . "&content=" . $content;
        $client = new Client();

        $request = new \GuzzleHttp\Psr7\Request('GET', $url);
        $promise = $client->sendAsync($request)->then(function ($response) {
            return 'Result: ' . $response->getBody();
        });
        $promise->wait();
    }
}