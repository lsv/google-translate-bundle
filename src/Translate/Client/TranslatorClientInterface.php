<?php

declare(strict_types=1);

namespace Lsv\GoogleTranslationBundle\Translate\Client;

use Google\Cloud\Translate\V2\TranslateClient;

interface TranslatorClientInterface
{
    public function getClient(): TranslateClient;
}
