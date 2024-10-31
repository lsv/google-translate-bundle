GoogleTranslateBundle
=====================

[![codecov](https://codecov.io/github/lsv/google-translate-bundle/branch/master/graph/badge.svg?token=th00dq8CkU)](https://codecov.io/github/lsv/google-translate-bundle)
[![SymfonyInsight](https://insight.symfony.com/projects/8e5bd5d0-6037-4537-9c45-1f11745fba0e/mini.svg)](https://insight.symfony.com/projects/8e5bd5d0-6037-4537-9c45-1f11745fba0e)
[![Mutation testing badge](https://img.shields.io/endpoint?style=plain&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Flsv%2Fgoogle-translate-bundle%2Fmaster)](https://dashboard.stryker-mutator.io/reports/google-translate-bundle/master)

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
