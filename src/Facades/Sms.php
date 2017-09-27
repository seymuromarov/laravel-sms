<?php

namespace Seymuromarov\Sms\Facades;

Use Illuminate\Support\Facades\Facade;

class Sms extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'seymuromarov-sms';
    }

}