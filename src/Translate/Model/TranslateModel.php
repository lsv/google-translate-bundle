<?php

declare(strict_types=1);

namespace Lsv\GoogleTranslationBundle\Translate\Model;

final readonly class TranslateModel
{
    public function __construct(
        public string $text,
        public string $sourceLanguage,
    ) {
    }
}
