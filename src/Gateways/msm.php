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

class Msm
{
    public function send_sms($mobile, $content)
    {
        if (is_array($mobile)) {
            $xml = ' <SMS-InsRequest>     <CLIENT user="' . config('sms-package.user') . '" pwd="' . config('sms-package.pass') . '" from="' . config('sms-package.from') . '"/>  ';
            foreach ($mobile as $phone) {
                $xml = $xml . '<INSERT to="' . $phone . '" text="' . $content . '" datacoding="0" />';
            }
            $xml = $xml . '</SMS-InsRequest>';
        } else {
            $xml = ' <SMS-InsRequest>     <CLIENT user="' . config('sms-package.user') . '" pwd="' . config('sms-package.pass') . '" from="' . config('sms-package.from') . '"/>    <INSERT to="' . $mobile . '" text="' . $content . '" datacoding="0" /> </SMS-InsRequest>';
        }
        $url = config('sms-package.msm_url');
        $client = new Client();

        $request = new Request(
            'POST',
            $url,
            ['Content-Type' => 'text/xml; charset=UTF8'],
            $xml
        );
        $promise = $client->sendAsync($request)->then(function ($response) {
            $xml = simplexml_load_string($response->getBody()->getContents());
            $result = [];
            $result['res'] = (int)$xml->STATUS["res"];
            $result['id'] = (int)$xml->STATUS["id"];
            $result['balance'] = (float)$xml->STATUS["balance"];
            echo(json_encode($result));
        });
        $promise->wait();
    }

//    public function balance()
//    {
//        return "currently gateway doesn't support balance option,however you can see balance as result when you send sms ";
//    }

}