GoogleTranslateBundle
=====================

## Usage

#### Command

```bash
bin/console google-translate:detect "your text here to detect language code used"
bin/console google-translate:translate "da" "your text here to translate"
```

#### Service

```php
<?php

use Lsv\GoogleTranslationBundle\Translate\TranslatorInterface;

final readonly class TranslateText
{
    public function __construct(
        private TranslatorInterface $translator,
    )
    {
    }

    public function translate(string $text): string
    {
        return $this->translator->translate($text, 'en', isHtml: true)->text;
    }
}
```

## Installation

```bash
composer require lsv/google-translate-bundle
```

You need to get a Google API key from the [Google Cloud Console](https://console.cloud.google.com/), and change it in your environment file.

### With flex

The bundle will be automatically enabled and the configuration will be added to your `.env` file.

### Without flex

Add the bundle to your `config/bundles.php` file

```bash

```php
return [
    // ...
    Lsv\GoogleTranslationBundle\GoogleTranslationBundle::class => ['all' => true],
];
```

#### Configuration

```yaml
# config/packages/google_translation.yaml
lsv_google_translate:
  google_api_key: '%env(GOOGLE_API_KEY)%'
```

````
# .env
GOOGLE_API_KEY=your_api_key_here
````