<?php

use Marshmallow\TranslatedCom\Objects\JobType;
use Marshmallow\TranslatedCom\Objects\DataFormat;
use Marshmallow\TranslatedCom\Objects\OutputFormat;

return [

    /**
     * The default API path
     */
    'path' => 'https://www.translated.net/hts/',


    /**
     * Your username at translated.com
     */
    'username' => env('TRANSLATED_COM_USERNAME', 'htsdemo'),


    /**
     * The password for your translated.com account
     */
    'password' => env('TRANSLATED_COM_PASSWORD', 'htsdemo5'),

    /**
     * Activate the sandbox for testing.
     */
    'sandbox' => env('TRANSLATED_COM_SANDBOX', false),

    /**
     * Default endpoint to sent the results to. If you leave this
     * as null then we will use our default package route to
     * handle the response.
     */
    'endpoint' => env('TRANSLATED_COM_ENDPOINT', null),


    /**
     * Default source language
     */
    'source_language' => 'Dutch',


    /**
     * Default target language(s)
     * Comma separated values for multiple targets: Italian,Spanish,Japanese
     */
    'target_language' => 'English',


    /**
     * Default project name
     */
    'project_name' => 'HTS-NONAME',


    /**
     * Default Job Type
     * These options are valid options you can use for the job type:
     *      JobType::PROFESSIONAL
     *      JobType::PREMIUM
     *      JobType::ECONOMY
     */
    'job_type' => JobType::PROFESSIONAL,


    /**
     * These options are valid options you can use for the job type:
     *      DataFormat::PDF
     *      DataFormat::PLAINTEXT
     *      DataFormat::TXT
     *      DataFormat::XML
     *      DataFormat::HTML
     *      DataFormat::HTM
     *      DataFormat::XLIFF
     *      DataFormat::ZIP
     *      DataFormat::RTF
     *      DataFormat::DOC
     *      DataFormat::DOCX
     *      DataFormat::AEA
     */
    'data_format' => DataFormat::PLAINTEXT,

    /**
     * Default output format of the api response:
     *      OutputFormat::JSON
     *      OutputFormat::PLAINTEXT
     */
    'output_format' => OutputFormat::JSON,


    /**
     * Store quotes in the database
     */
    'store_qoutes' => true,


    'morphables' => [
        //
    ],
];
