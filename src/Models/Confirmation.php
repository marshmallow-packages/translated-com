<?php

namespace Marshmallow\TranslatedCom\Models;

use Illuminate\Database\Eloquent\Model;
use Marshmallow\TranslatedCom\Models\Order;

class Confirmation extends Model
{
    protected $table = 'translated_com_confirmation';

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class, 'pid', 'pid');
    }
}
