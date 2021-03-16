<?php

namespace Marshmallow\TranslatedCom;

use Marshmallow\TranslatedCom\Objects\Quote;
use Marshmallow\TranslatedCom\Objects\Confirm;

class TranslatedCom
{
    public function qoute(string $text): Quote
    {
        return new Quote($text);
    }

    public function confirm(int $pid, bool $confirm = true): Confirm
    {
        return new Confirm($pid, $confirm);
    }

    public function shouldStore(): bool
    {
        return config('translated-com.store_qoutes');
    }

    public function getCallbackPath(string $endpoint = null): string
    {
        return ($endpoint !== null) ? $endpoint : route('translated-com-callback');
    }
}
