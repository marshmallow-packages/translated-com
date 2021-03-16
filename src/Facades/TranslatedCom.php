<?php

namespace Marshmallow\TranslatedCom\Facades;

use Illuminate\Support\Facades\Facade;
use Marshmallow\TranslatedCom\TranslatedCom as BaseTranslatedCom;

class TranslatedCom extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BaseTranslatedCom::class;
    }
}
