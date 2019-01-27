<?php

namespace Seymuromarov\Sms\Model;

use Illuminate\Database\Eloquent\Model;

class SmsLoginCode extends Model
{
    protected $table = "sms_login_codes";

    protected $fillable = [
        'number',
        'code',
    ];

}
