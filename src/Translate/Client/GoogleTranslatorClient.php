<?php

declare(strict_types=1);

namespace Lsv\GoogleTranslationBundle\Translate\Client;

use Google\Cloud\Translate\V2\TranslateClient;

final readonly class GoogleTranslatorClient implements TranslatorClientInterface
{
    public function __construct(
        #[\SensitiveParameter] private string $apiKey,
    ) {
    }

    public function getClient(): TranslateClient
    {
        return new TranslateClient([
            'key' => $this->apiKey,
        ]);
    }
}
