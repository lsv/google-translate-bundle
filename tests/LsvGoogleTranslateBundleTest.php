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

namespace Lsv\GoogleTranslationBundle\Tests;

use Lsv\GoogleTranslationBundle\LsvGoogleTranslateBundle;
use PHPUnit\Framework\TestCase;

class LsvGoogleTranslateBundleTest extends TestCase
{
    public function testBundle(): void
    {
        self::assertSame(realpath(__DIR__.'/..'), (new LsvGoogleTranslateBundle())->getPath());
    }
}
