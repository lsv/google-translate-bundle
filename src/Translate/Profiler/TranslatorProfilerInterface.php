<?php

declare(strict_types=1);

/**
 * Copyright (c) 2024 Martin Aarhof
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/lsv/google-translate-bundle/blob/master/LICENSE
 *
 */

namespace Lsv\GoogleTranslationBundle\Translate\Profiler;

interface TranslatorProfilerInterface
{
    public function start(
        string $type,
        string $query,
        ?string $sourceLanguage = null,
        ?string $targetLanguage = null,
    ): TranslationProfileModel;

    public function end(TranslationProfileModel $event): void;

    /**
     * @return TranslationProfileModel[]
     */
    public function getProfiles(): array;
}
