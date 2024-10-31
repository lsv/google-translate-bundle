<?php

declare(strict_types=1);

namespace Lsv\GoogleTranslationBundle\Tests\DependencyInjection;

use Lsv\GoogleTranslationBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    public function testConfiguration(): void
    {
        $configuration = new Configuration();
        $config = $configuration->getConfigTreeBuilder()->buildTree();
        self::assertSame('lsv_google_translate', $config->getPath());
    }
}
