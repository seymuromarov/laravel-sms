<?php

namespace Seymuromarov\Sms;

use Seymuromarov\Sms\Gateways\nexmoSms;
use Seymuromarov\Sms\Gateways\smsApi;
use Seymuromarov\Sms\Gateways\Msm;
use Seymuromarov\Sms\Gateways\Clockwork;
use Seymuromarov\Sms\Gateways\SmsRu;

class SmsGenerator
{
    protected $gateway;

    function __construct()
    {
        self::gateway(config('sms-package.provider'));
    }

    public function send($mobile, $content)
    {
        if ($this->gateway) {
            return $this->gateway->send_sms($mobile, $content);
        } else {
            return "ERROR WRONG PROVIDER CURRENTLY WE SUPPORT -> clockwork,msm,smsRu,smsApi,nexmo if u need other provider just ask it !";
        }
    }

    public function balance()
    {
        if (method_exists($this->gateway, 'balance')) {
            echo $this->gateway->balance();
        } else {
            echo "currently gateway doesn't support balance option,however you can see balance as result when you send sms ";
        }

    }

    public function gateway($name)
    {
        switch ($name) {
            case 'msm':
                $this->gateway = new Msm();
                break;
            case 'clockwork':
                $this->gateway = new Clockwork();
                break;
            case 'smsRu':
                $this->gateway = new SmsRu();
                break;
            case 'smsApi':
                $this->gateway = new smsApi();
                break;
            case 'nexmo':
                $this->gateway = new nexmoSms();
                break;
            default:
                $this->gateway = false;
                break;
        }
        return $this;
    }

}