<?php

namespace Marshmallow\TranslatedCom\Objects;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Marshmallow\TranslatedCom\Objects\Method;
use Marshmallow\TranslatedCom\Facades\TranslatedCom;
use Marshmallow\TranslatedCom\Objects\Traits\Apiable;

class Quote
{
    use Apiable;

    protected $s;
    protected $t;
    protected $text;
    protected $pn;
    protected $jt;
    protected $w;
    protected $tm;
    protected $endpoint;
    protected $subject;
    protected $instructions;
    protected $model_type;
    protected $model_id;
    protected $column;
    protected $flex;

    public function __construct(string $text)
    {
        $this->setText($text)
            ->setFunction(Method::QUOTE)
            ->setOutputFormat(config('translated-com.output_format'))
            ->setEndpoint(config('translated-com.endpoint'))
            ->setUsername(config('translated-com.username'))
            ->setPassword(config('translated-com.password'))
            ->setSandbox(config('translated-com.sandbox'))
            ->setSourceLanguage(config('translated-com.source_language'))
            ->setTargetLanguage(config('translated-com.target_language'))
            ->setJobType(config('translated-com.job_type'))
            ->setProjectName(config('translated-com.project_name'))
            ->setDataFormat(config('translated-com.data_format'));
    }

    public function getRequestDataArray(): array
    {
        return [
            's' => $this->s,
            't' => $this->t,
            'of' => $this->of,
            'text' => $this->text,
            'df' => $this->df,
            'endpoint' => $this->endpoint,
        ];
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function setSourceLanguage(string $source_language): self
    {
        $this->s = $source_language;
        return $this;
    }

    public function setTargetLanguage(string $target_language): self
    {
        $this->t = $target_language;
        return $this;
    }

    public function setTargetLanguages(array $target_language): self
    {
        $this->t = join(',', $target_language);
        return $this;
    }

    public function setProjectName(string $project_name): self
    {
        $this->pn = $project_name;
        return $this;
    }

    public function setJobType(string $job_type): self
    {
        $this->jt = $job_type;
        return $this;
    }

    public function setWordCount(int $word_count): self
    {
        $this->w = $word_count;
        return $this;
    }

    public function setTranslationMemory(string $translation_memory): self
    {
        $this->tm = $translation_memory;
        return $this;
    }

    public function setEndpoint(string $endpoint = null): self
    {
        $this->endpoint = TranslatedCom::getCallbackPath($endpoint);
        return $this;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    public function setInstructions(string $instruction): self
    {
        $this->instructions = $instruction;
        return $this;
    }

    public function setModel(Model $model): self
    {
        $this->model_type = get_class($model);
        $this->model_id = $model->id;
        return $this;
    }

    public function setColumn(string $column): self
    {
        $this->column = $column;
        return $this;
    }

    public function setFlex(array $flex_key = null): self
    {
        $this->flex = $flex_key;
        return $this;
    }
}
