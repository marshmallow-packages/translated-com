<?php

namespace Marshmallow\TranslatedCom\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Marshmallow\TranslatedCom\Models\Result;
use Marshmallow\TranslatedCom\Models\Confirmation;
use Marshmallow\TranslatedCom\Facades\TranslatedCom;

class Order extends Model
{
    protected $table = 'translated_com_orders';

    protected $guarded = [];

    protected $casts = [
        'flex' => 'array',
        'confirmed_at' => 'datetime',
        'delivery_date' => 'datetime',
    ];

    public function confirm()
    {
        TranslatedCom::confirm($this->pid)->run();
        $this->update([
            'confirmed_at' => now(),
            'confirmed_by' => auth()->user()->id,
        ]);
    }

    public function model()
    {
        return $this->morphTo();
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function confirmations()
    {
        return $this->hasMany(Confirmation::class, 'pid', 'pid');
    }

    public function translations()
    {
        return $this->hasMany(Result::class, 'pid', 'pid');
    }
}
