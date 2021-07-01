<?php

namespace Marshmallow\TranslatedCom\Traits;

use Marshmallow\TranslatedCom\Objects\Order;
use Marshmallow\TranslatedCom\Objects\DataFormat;

trait TranslatedCom
{
    protected $translated_com_order = [];

    public function getTranslatedComDataFormats()
    {
        return $this->translated_com;
    }

    public function createTranslationOrders($config = [])
    {
        $order = [];
        $translatables = $this->getTranslatedComDataFormats();
        foreach ($translatables as $column => $data_format) {

            if ($data_format == DataFormat::FLEX) {
                $this->createTranslationOrdersFromFlex($column);
            } else {
                $order = new Order($this->{$column}, $data_format);
                $order->linkModel($this, $column);
                $this->translated_com_order[] = $order;
            }
        }

        foreach ($this->translated_com_order as $order) {
            $order->create($config);
        }
    }

    protected function createTranslationOrdersFromFlex($model_column)
    {
        $flex_layout_translation_settings = DataFormat::flexible();
        $model_flex_data = $this->{$model_column};
        if (is_string($model_flex_data)) {
            $model_flex_data = json_decode($model_flex_data, true);
        }
        foreach ($model_flex_data as $flex_layout) {
            $key = $flex_layout['key'];
            $layout = $flex_layout['layout'];
            $attributes = $flex_layout['attributes'];
            if (array_key_exists($layout, $flex_layout_translation_settings)) {
                $data_formats = $flex_layout_translation_settings[$layout];
                foreach ($data_formats as $column => $data_format) {

                    if (!$attributes[$column]) {
                        continue;
                    }

                    $order = new Order($attributes[$column], $data_format);
                    $order->linkModel($this, $model_column);
                    $order->linkFlex($key, $column);
                    $this->translated_com_order[] = $order;
                }
            }
        }
    }
}
