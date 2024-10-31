<?php

declare(strict_types=1);

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
