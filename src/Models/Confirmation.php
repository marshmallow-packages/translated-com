<?php

namespace Marshmallow\TranslatedCom\Models;

use Illuminate\Database\Eloquent\Model;

class Confirmation extends Model
{
    protected $table = 'translated_com_confirmation';

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(config('translated-com.models.order'), 'pid', 'pid');
    }
}
