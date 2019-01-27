<?php

namespace Seymuromarov\Sms\Model;

use Illuminate\Database\Eloquent\Model;

class SmsSent extends Model
{
    protected $table = "sms_sent";

    protected $fillable = [
        'number',
        'message',
        'response'
    ];

}
