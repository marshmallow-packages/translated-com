<?php

namespace Marshmallow\TranslatedCom\Events;

use Illuminate\Queue\SerializesModels;
use Marshmallow\TranslatedCom\Models\Order;
use Marshmallow\TranslatedCom\Models\Result;
use Illuminate\Foundation\Events\Dispatchable;
use Marshmallow\TranslatedCom\Models\Confirmation;

class TranslationRecieved
{
    use Dispatchable, SerializesModels;

    /**
     * The order that was send to Translated.com
     *
     * @var Marshmallow\TranslatedCom\Models\Order
     */
    public $order;


    /**
     * The confirmation that was send to Translated.com
     *
     * @var Marshmallow\TranslatedCom\Models\Confirmation
     */
    public $confirmation;


    /**
     * The result that was received from Translated.com
     *
     * @var Marshmallow\TranslatedCom\Models\Result
     */
    public $result;


    public function __construct(Order $order, Confirmation $confirmation, Result $result)
    {
        $this->order = $order;
        $this->confirmation = $confirmation;
        $this->result = $result;
    }
}
