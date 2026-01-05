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

namespace Lsv\GoogleTranslationBundle\Tests\DependencyInjection;

use Lsv\GoogleTranslationBundle\Command\DetectCommand;
use Lsv\GoogleTranslationBundle\Command\TranslateCommand;
use Lsv\GoogleTranslationBundle\DependencyInjection\LsvGoogleTranslateExtension;
use Lsv\GoogleTranslationBundle\Translate\Client\GoogleTranslatorClient;
use Lsv\GoogleTranslationBundle\Translate\Client\TranslatorClientInterface;
use Lsv\GoogleTranslationBundle\Translate\GoogleTranslator;
use Lsv\GoogleTranslationBundle\Translate\Profiler\GoogleTranslatorProfiler;
use Lsv\GoogleTranslationBundle\Translate\Profiler\TranslatorProfilerInterface;
use Lsv\GoogleTranslationBundle\Translate\TranslatorInterface;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class LsvGoogleTranslateExtensionTest extends AbstractExtensionTestCase
{
    public function testLoaded(): void
    {
        $this->load();
        $this->assertContainerBuilderHasParameter('lsv_google_translate.google_api_key', 'apikey');

        $this->assertContainerBuilderHasService(GoogleTranslatorClient::class);
        $this->assertContainerBuilderHasService(TranslatorClientInterface::class);

        $this->assertContainerBuilderHasService(TranslateCommand::class);
        $this->assertContainerBuilderHasService(DetectCommand::class);

        $this->assertContainerBuilderHasService(GoogleTranslatorProfiler::class);
        $this->assertContainerBuilderHasService(TranslatorProfilerInterface::class);

        $this->assertContainerBuilderHasService(GoogleTranslator::class);
        $this->assertContainerBuilderHasService(TranslatorInterface::class);
    }

    /**
     * @return string[]
     */
    protected function getMinimalConfiguration(): array
    {
        return [
            'google_api_key' => 'apikey',
        ];
    }

    protected function getContainerExtensions(): array
    {
        return [
            new LsvGoogleTranslateExtension(),
        ];
    }
}
