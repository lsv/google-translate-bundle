<?php

declare(strict_types=1);

namespace Lsv\GoogleTranslationBundle\Translate\Model;

final readonly class DetectModel
{
    public function __construct(
        public string $code,
        public float|int|null $confidence,
    ) {
    }
}
