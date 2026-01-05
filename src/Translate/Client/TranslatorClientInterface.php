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

namespace Lsv\GoogleTranslationBundle\Translate\Client;

use Google\Cloud\Translate\V2\TranslateClient;

interface TranslatorClientInterface
{
    public function getClient(): TranslateClient;
}
