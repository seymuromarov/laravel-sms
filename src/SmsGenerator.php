<?php

namespace Seymuromarov\Sms;

use App\User;
use Illuminate\Support\Facades\Auth;
use Seymuromarov\Sms\Gateways\Clickatell;
use Seymuromarov\Sms\Gateways\nexmoSms;
use Seymuromarov\Sms\Gateways\smsApi;
use Seymuromarov\Sms\Gateways\Msm;
use Seymuromarov\Sms\Gateways\Clockwork;
use Seymuromarov\Sms\Gateways\SmsRu;
use Seymuromarov\Sms\Model\SmsLoginCode;
use Seymuromarov\Sms\Model\SmsSent;

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
            $result = $this->gateway->send_sms($mobile, $content);
            return $this->handle($mobile, $content, $result);
        } else {
            return "ERROR WRONG PROVIDER CURRENTLY WE SUPPORT -> clockwork,msm,smsRu,smsApi,nexmo,clickatell if u need other provider just ask it !";
        }
    }

    public function balance()
    {
        if (method_exists($this->gateway, 'balance')) {
            return $this->gateway->balance();
        } else {
            return "currently gateway doesn't support balance option,however you can see balance as result when you send sms ";
        }

    }

    public function int_random($len = 6)
    {
        $word = array_merge(range(1, 9));
        shuffle($word);
        return (int)substr(implode($word), 0, $len);
    }


    public function login_code($mobile, $message = null, $len = 6)
    {
        if (Auth::check()) {
            Auth::logout();
        }

        $code = $this->int_random($len);
        $message = $message . " " . $code;
        SmsLoginCode::create([
            "number" => $mobile,
            "code" => $code
        ]);

        $this->gateway->send_sms($mobile, $message);

    }

    public function check_login($mobile, $code, $id = null)
    {
        if (Auth::check()) {
            Auth::logout();
        }

        $check = SmsLoginCode::where('number', $mobile)
            ->orderBy('id', 'desc')
            ->select('code')
            ->first();

        if ($check->code == $code) {
            if ($id == null) {
                Auth::login(User::where(config('sms-package.db_phone'), $mobile)->first());
            } else {
                Auth::loginUsingId($id);
            }
            return true;
        }
        return false;

    }

    public function handle($numbers, $message, $response = null)
    {
        if (config('sms-package.db')) {
            foreach ($numbers as $number) {
                SmsSent::create([
                    "number" => $number,
                    "message" => $message,
                    "response" => $response
                ]);
            }
        }
        return $response;

    }

    public function handleLoginCode($number, $message, $response = null)
    {
        SmsLoginCode::create([
            "number" => $number,
            "message" => $message,
            "response" => $response
        ]);

        return $response;

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
            case 'clickatell':
                $this->gateway = new Clickatell();
                break;
            default:
                $this->gateway = false;
                break;
        }
        return $this;
    }

}