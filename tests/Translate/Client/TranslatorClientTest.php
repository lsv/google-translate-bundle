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

namespace Lsv\GoogleTranslationBundle\Tests\Translate\Client;

use Google\Cloud\Translate\V2\TranslateClient;
use Lsv\GoogleTranslationBundle\Translate\Client\GoogleTranslatorClient;
use PHPUnit\Framework\TestCase;

class TranslatorClientTest extends TestCase
{
    public function testGetClient(): void
    {
        $client = new GoogleTranslatorClient('apikey');
        $googleClient = $client->getClient();

        $this->assertInstanceOf(TranslateClient::class, $googleClient);
        $ref = new \ReflectionClass($googleClient);
        $key = $ref->getProperty('key');
        self::assertSame('apikey', $key->getValue($googleClient));
    }
}
