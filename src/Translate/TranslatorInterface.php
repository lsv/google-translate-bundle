<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024-2026 Martin Aarhof
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/lsv/google-translate-bundle/blob/master/LICENSE
 *
 */

namespace Lsv\GoogleTranslationBundle\Translate;

use Lsv\GoogleTranslationBundle\Translate\Model\DetectModel;
use Lsv\GoogleTranslationBundle\Translate\Model\TranslateModel;

interface TranslatorInterface
{
    public function detect(string $query): DetectModel;

    /**
     * @return string[]
     */
    public function languages(?string $targetLanguage): array;

    /**
     * @param string|string[] $query
     *
     * @return TranslateModel|TranslateModel[]
     */
    public function translate(
        string|array $query,
        string $targetLanguage = 'en',
        ?string $sourceLanguage = null,
        bool $isHtml = false,
    ): TranslateModel|array;
}
