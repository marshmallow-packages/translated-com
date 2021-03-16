<?php

namespace Marshmallow\TranslatedCom\Objects;

use Marshmallow\TranslatedCom\Objects\Method;
use Marshmallow\TranslatedCom\Objects\Traits\Apiable;

class Confirm
{
    use Apiable;

    protected $pid;
    protected $c;

    public function __construct(int $pid, bool $confirm = true)
    {
        $this->setProjectIdentifier($pid)
            ->setUsername(config('translated-com.username'))
            ->setFunction(Method::CONFIRM)
            ->setPassword(config('translated-com.password'))
            ->setSandbox(config('translated-com.sandbox'))
            ->setConfirmationFlag($confirm)
            ->setOutputFormat(config('translated-com.output_format'))
            ->setDataFormat(config('translated-com.data_format'));
    }

    public function getRequestDataArray(): array
    {
        return [
            'pid' => $this->pid,
            'c' => $this->c,
        ];
    }

    public function setProjectIdentifier(int $project_identifier): self
    {
        $this->pid = $project_identifier;
        return $this;
    }

    public function setConfirmationFlag(bool $confirmation_flag): self
    {
        $this->c = $confirmation_flag;
        return $this;
    }
}
