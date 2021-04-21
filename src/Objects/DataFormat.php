<?php

namespace Marshmallow\TranslatedCom\Objects;

use Marshmallow\Nova\Flexible\Flex;

class DataFormat
{
    public const PDF = 'pdf';
    public const PLAINTEXT = 'plaintext';
    public const TXT = 'txt';
    public const XML = 'xml';
    public const HTML = 'html';
    public const HTM = 'htm';
    public const XLIFF = 'xliff';
    public const ZIP = 'zip';
    public const RTF = 'rtf';
    public const DOC = 'doc';
    public const DOCX = 'docx';
    public const AEA = 'aea';
    public const FLEXIBLE = 'flex';
    public const FLEX = 'flex';

    public static function flexible(): array
    {
        $return_array = [];
        $flexibles = (new Flex)->getLayouts();
        foreach ($flexibles as $name => $class_name) {
            $flex = new $class_name;
            if (!method_exists($flex, 'getTranslatedComDataFormats')) {
                continue;
            }
            $return_array[$name] = $flex->getTranslatedComDataFormats();
        }
        return $return_array;
    }
}
