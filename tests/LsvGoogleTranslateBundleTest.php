<?php

declare(strict_types=1);

namespace Lsv\GoogleTranslationBundle\Tests;

use Lsv\GoogleTranslationBundle\LsvGoogleTranslateBundle;
use PHPUnit\Framework\TestCase;

class LsvGoogleTranslateBundleTest extends TestCase
{
    public function testBundle(): void
    {
        $bundle = new LsvGoogleTranslateBundle();
        self::assertSame('LsvGoogleTranslateBundle', $bundle->getName());
        self::assertSame(realpath(__DIR__.'/..'), $bundle->getPath());
    }
}
