![alt text](https://marshmallow.dev/cdn/media/logo-red-237x46.png "marshmallow.")

# Laravel Zoho Desk

[![Version](https://img.shields.io/packagist/v/marshmallow/zoho-desk)](https://github.com/marshmallow-packages/pages)
[![Issues](https://img.shields.io/github/issues/marshmallow-packages/zoho-desk)](https://github.com/marshmallow-packages/pages)
[![Licence](https://img.shields.io/github/license/marshmallow-packages/zoho-desk)](https://github.com/marshmallow-packages/pages)
![PHP Syntax Checker](https://github.com/marshmallow-packages/zoho-desk/workflows/PHP%20Syntax%20Checker/badge.svg)

This packages provides you with the ability to easily connect your Laravel application to ZohoDesk.

## Installation

### Composer

You can install the package via composer:

```bash
composer require marshmallow/translated-com
```

### Usage

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

## Variables

## Objects

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
