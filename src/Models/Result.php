<?php

namespace Marshmallow\TranslatedCom\Models;

use Illuminate\Database\Eloquent\Model;
use Marshmallow\TranslatedCom\Models\Order;

class Result extends Model
{
    protected $table = 'translated_com_results';

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class, 'pid', 'pid');
    }
}
