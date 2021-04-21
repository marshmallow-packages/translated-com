![alt text](https://marshmallow.dev/cdn/media/logo-red-237x46.png "marshmallow.")

# Laravel Translated.com

[![Version](https://img.shields.io/packagist/v/marshmallow/translated-com)](https://github.com/marshmallow-packages/pages)
[![Issues](https://img.shields.io/github/issues/marshmallow-packages/translated-com)](https://github.com/marshmallow-packages/pages)
[![Licence](https://img.shields.io/github/license/marshmallow-packages/translated-com)](https://github.com/marshmallow-packages/pages)
![PHP Syntax Checker](https://github.com/marshmallow-packages/translated-com/workflows/PHP%20Syntax%20Checker/badge.svg)

This packages provides you with the ability to easily connect your Laravel application to Translated.com.

## Installation

### Composer

You can install the package via composer:

```bash
composer require marshmallow/translated-com
php artisan migrate
php artisan marshmallow:resource TranslatedComOrder TranslatedCom
php artisan marshmallow:resource TranslatedComConfirmation TranslatedCom
php artisan marshmallow:resource TranslatedComResult TranslatedCom
```

Next; publish the config:

```bash
php artisan vendor:publish --provider="Marshmallow\\TranslatedCom\\TranslatedComServiceProvider"
```

Make sure it's allowed for Translated.com to do a POST request to the route where we handle the response by adding it to the `$except` array in the `VerifyCsrfToken` middleware.

```php
protected $except = [
    '/translated-com/callback'
];
```

### Resource usage

#### Your models

You can create an order at Translated.com from your models. You do need to prepare your models for this. You need to make sure this package knows which columns on your model should be translated and what kind of data is in the column. Also, you need to implement the `TranslatedCom` trait.

```php
use Marshmallow\TranslatedCom\Objects\DataFormat;
use Marshmallow\TranslatedCom\Traits\TranslatedCom;

class Page extends Model
{
    use TranslatedCom;

    protected $translated_com = [
        'name' => DataFormat::PLAINTEXT,
        'layout' => DataFormat::FLEX,
        'content' => DataFormat::HTML,
    ];
}
```

Once your model implemantation is ready, you can get this model and create the order like the example below.

```php
$page = Page::first();
$page->createTranslationOrders();
```

You can also overrule the defaults from the config by calling the setter methods as an array. Please check the example below:

```php
$page->createTranslationOrders([
	'setSourceLanguage' => ['DE'],
	'setTargetLanguage' => ['ES'],
	'setEndpoint' => ['https://marshmallow.dev'],
	'setOutputFormat' => [OutputFormat::JSON],
	'setUsername' => ['stef@marshmallow.dev'],
	'setPassword' => ['mr-mallow-2021'],
	'setSandbox' => [true],
	'setJobType' => [JobType::PROFESSIONAL],
	'setProjectName' => ['Marshmallow'],
	'setDataFormat' => [DataFormat::PLAINTEXT],
]);
```

#### Flexible

If you are using the flexible package, you need to add the same logic as above to your Flexible layouts. Please make sure you use the `DataFormat::FLEX` on your model implementation so we know that we need to get the flexible information.

```php
use Marshmallow\TranslatedCom\Objects\DataFormat;
use Marshmallow\TranslatedCom\Traits\TranslatedCom;

class ContentWithLeftTitleLayout extends MarshmallowLayout
{
    use TranslatedCom;

    protected $translated_com = [
        'title' => DataFormat::PLAINTEXT,
        'content' => DataFormat::HTML,
    ];
}
```

### Manual usage

#### Get a quote

First you create a new quote. You will have to confim this qoute before Translated.com will start translating your content. This request will return the full response of the API. This is done because you might not have the database option enabled in the config. Because you get the full response, you can do anything with it.

```php
use Marshmallow\TranslatedCom\Facades\TranslatedCom;

/**
 * The response of the Translated.com api
 *
 * @var \Illuminate\Http\Client\Response
 */
$response = TranslatedCom::qoute('Test string')->run();
```

#### Accept a quote

Once a qoute has been done, you need to confim/accept it so it will be translated. Use the command below to make this happen. This request will return the full response of the API. This is done because you might not have the database option enabled in the config. Because you get the full response, you can do anything with it.

```php
use Marshmallow\TranslatedCom\Facades\TranslatedCom;

/**
 * The response of the Translated.com api
 *
 * @var \Illuminate\Http\Client\Response
 */
$response = TranslatedCom::confirm($pid = 10000)->run();
```

#### Get the translation

Once Translated.com has translated your text, they will send a response to your server. By default this will be send to the `/translated-com/callback` url of your application but this can be changed in your config file. If you are going to change this and handle the response yourself you should implement this with the following logic in mind.

Translated.com will send a POST request to the url u provide in the config file with the following data:

```json
{
    "text": "VGVzdCBzdHJpbmc=",
    "pid": "36078716",
    "t": "Dutch"
}
```

#### Events

When a translation is received, this package will trigger the `TranslationRecieved` event. You can listen to this and do any magic you need to perform when a translation is finalized. Listen to this event in you `EventServiceProvider`.

```php
use Marshmallow\TranslatedCom\Events\TranslationRecieved;

protected $listen = [

    //...

    TranslationRecieved::class => [
        // Your listeners
    ],
];
```

You will have the following public variables to access in your listener.

```php
namespace App\Listeners;

use Marshmallow\TranslatedCom\Events\TranslationRecieved;

class TranslatedComSandboxListener
{
    public function handle(TranslationRecieved $event)
    {
        /**
         * The order that was send to Translated.com
         *
         * @var Marshmallow\TranslatedCom\Models\Order
         */
        $event->order;


        /**
         * The confirmation that was send to Translated.com
         *
         * @var Marshmallow\TranslatedCom\Models\Confirmation
         */
        $event->confirmation;


        /**
         * The result that was received from Translated.com
         *
         * @var Marshmallow\TranslatedCom\Models\Result
         */
        $event->result;
    }
}
```

## Test run

If you want to create a test run to validate your callback is working properly, you can use the command below.

```php
php artisan translated-com:test
```

## Methods

Below we have listed all the public methods that you can use to add more data to the translation request or override the behaviour of the config file.

### Quote

Below you will find the methods you can use to enrich your translation data. When you create a quote, most of these fields are filled via the config file so please reference the config file to see if you can just used that.

```php
$quote->setText(string $text);
$quote->setSourceLanguage(string $source_language);
$quote->setTargetLanguage(string $target_language);
$quote->setTargetLanguages(array $target_language);
$quote->setProjectName(string $project_name);
$quote->setJobType(string $job_type);
$quote->setWordCount(int $word_count);
$quote->setDataFormat(string $data_format);
$quote->setTranslationMemory(string $translation_memory);
$quote->setEndpoint(string $endpoint = null);
$quote->setSubject(string $subject);
$quote->setInstructions(string $instruction);
$quote->setUsername(string $username);
$quote->setPassword(string $password);
$quote->setOutputFormat(string $output_format = null);
```

### Confirm

Below you will find the methods you can use to enrich your translation data. When you create a confirmation you need to add them to the constructor so these methods will be run by default.

```php
$confirm->setProjectIdentifier(int $project_identifier);
$confirm->setConfirmationFlag(bool $confirmation_flag);
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email stef@marshmallow.dev instead of using the issue tracker.

## Credits

-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
