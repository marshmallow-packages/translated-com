<?php

namespace Marshmallow\TranslatedCom\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'translated_com_results';

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(config('translated-com.models.order'), 'pid', 'pid');
    }
}
