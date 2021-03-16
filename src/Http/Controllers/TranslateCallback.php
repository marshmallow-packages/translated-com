<?php

namespace Marshmallow\TranslatedCom\Http\Controllers;

use Illuminate\Routing\Controller;
use Marshmallow\TranslatedCom\Models\Order;
use Marshmallow\TranslatedCom\Models\Result;
use Marshmallow\TranslatedCom\Http\Requests\TranslateCallbackRequest;

class TranslateCallback extends Controller
{
    public function __invoke(TranslateCallbackRequest $request)
    {
        $order = Order::where('pid', $request->pid)->firstOrFail();

        Result::create([
            'pid' => $order->pid,
            'text' => $request->text,
            't' => $request->t,
        ]);

        return 1;
    }
}
