<?php

namespace Marshmallow\TranslatedCom\Objects;

use Illuminate\Database\Eloquent\Model;
use Marshmallow\TranslatedCom\Objects\DataFormat;
use Marshmallow\TranslatedCom\Facades\TranslatedCom;

class Order
{
    protected $content;
    protected $data_format;
    protected $model;
    protected $column;
    protected $key;
    protected $flex_column;

    public function __construct($content, $data_format = DataFormat::PLAINTEXT)
    {
        $this->content = $content;
        $this->data_format = $data_format;
    }

    public function create($quote_methods = [])
    {
        $quote = TranslatedCom::qoute($this->content)
            ->setDataFormat($this->data_format)
            ->setModel($this->model)
            ->setColumn($this->column)
            ->setFlex(
                $this->getFlexKey()
            );

        /**
         * Run extra quote methods if they are provided
         */
        foreach ($quote_methods as $method => $params) {
            $quote->{$method}(...$params);
        }

        /**
         * Create the quotation
         */
        $quote->run();
    }

    public function linkModel(Model $model, string $column): self
    {
        $this->model = $model;
        $this->column = $column;
        return $this;
    }

    public function linkFlex($key, $flex_column): self
    {
        $this->key = $key;
        $this->flex_column = $flex_column;
        return $this;
    }

    public function getFlexKey()
    {
        if ($this->key && $this->flex_column) {
            return [
                'key' => $this->key,
                'column' => $this->flex_column,
            ];
        }
        return null;
    }
}
