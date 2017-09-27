<?php

namespace Seymuromarov\Sms;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\App;
use SimpleXMLElement;

class SmsGenerator
{
    public function sendHTTP($mobile, $content)
    {
        if (is_array($mobile)) {
            $mobile = implode(',', $mobile);
        }
        if (config('sms-package.provider') == "msm") {
            $url = "http://api.msm.az/sendsms?user=" . config('sms-package.user') .
                "&password=" . config('sms-package.pass') .
                "&gsm=" . $mobile .
                "&from=" . config('sms-package.from') .
                "&text=" . $content;
        } elseif (config('sms-package.provider') == "clockwork") {
            $url = "http://api.clockworksms.com/http/send.aspx?key=" . config('sms-package.pass') . "&to=" . $mobile . "&content=" . $content;
        } else {
            return "wrong provider,We only support msm,clockwork";
        }
        $client = new Client();

        $request = new \GuzzleHttp\Psr7\Request('GET', $url);
        $promise = $client->sendAsync($request)->then(function ($response) {
            echo 'Result: ' . $response->getBody();
        });
        $promise->wait();
    }

    public function send($mobile, $content)
    {
        if (config('sms-package.provider') == "msm") {
            self::msm_xml($mobile, $content);
        } elseif (config('sms-package.provider') == "clockwork") {
            self::clockwork_xml($mobile, $content);
        } else {
            return "wrong provider,We only support msm,clockwork";
        }

    }

    public function balance()
    {
        if (config('sms-package.provider') == "clockwork") {
            $url = "http://api.clockworksms.com/http/balance?key=" . config('sms-package.pass');
            $client = new Client();
            $request = new \GuzzleHttp\Psr7\Request('GET', $url);
            $promise = $client->sendAsync($request)->then(function ($response) {
                echo $response->getBody();
            });
            $promise->wait();
        } else {
            return "only works with clockwork";
        }
    }

    public static function msm_xml($mobile, $content)
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

    public static function clockwork_xml($mobile, $content)
    {
        $url = config('sms-package.clockwork_url');
        if (is_array($mobile)) {
            $xml = '<Message><Key>' . config('sms-package.pass') . '</Key>';
            foreach ($mobile as $phone) {
                $xml = $xml . ' <SMS><To>' . $phone . '</To><Content>' . $content . '</Content></SMS>';
            }
            $xml = $xml . '</Message>';
        } else {
            $xml = '<Message><Key>' . config('sms-package.pass') . '</Key><SMS><To>' . $mobile . '</To><Content>' . $content . '</Content></SMS></Message>';
        }
        $client = new Client();

        $request = new Request(
            'POST',
            $url,
            ['Content-Type' => 'text/xml; charset=UTF8'],
            $xml
        );
        $promise = $client->sendAsync($request)->then(function ($response) {
            $xml = simplexml_load_string($response->getBody()->getContents());
            echo(json_encode($xml));
        });
        $promise->wait();
    }
}