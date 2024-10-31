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

namespace Lsv\GoogleTranslationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LsvGoogleTranslateBundle extends Bundle
{
    public function getPath(): string
    {
        return dirname(__DIR__);
    }
}
