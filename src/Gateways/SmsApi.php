<?php
/**
 * Created by PhpStorm.
 * User: omaro
 * Date: 10/7/2017
 * Time: 19:53
 */

namespace Seymuromarov\Sms\Gateways;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

class smsApi
{

    public function send_sms($mobile, $content)
    {
        if (is_array($mobile)) {
            $mobile = implode(',', $mobile);
        }
        $url = config('sms-package.smsApi_url') . "&username=" . config('sms-package.user') . "&password=" . config('sms-package.pass') . "&from=" . config('sms-package.from') . "&to=" . $mobile . "&message=" . $content;
        $client = new Client();

        $request = new \GuzzleHttp\Psr7\Request('GET', $url);
        $promise = $client->sendAsync($request)->then(function ($response) {
            return $response->getBody();
        });
        $promise->wait();
    }

    public function balance()
    {
        $url = "https://api.smsapi.com/user.do?username=" . config('sms-package.user') . "&password=" . config('sms-package.pass') . "&credits=1&format=json";
        $client = new Client();
        $request = new \GuzzleHttp\Psr7\Request('GET', $url);
        $promise = $client->sendAsync($request)->then(function ($response) {
            return $response->getBody();
        });
        $promise->wait();
    }


}