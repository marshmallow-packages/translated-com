<?php

use Illuminate\Support\Facades\Route;
use Marshmallow\TranslatedCom\Http\Controllers\TranslateCallback;

Route::post('/translated-com/callback', TranslateCallback::class)->name('translated-com-callback');
