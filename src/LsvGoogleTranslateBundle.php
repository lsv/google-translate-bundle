<?php

declare(strict_types=1);

namespace Lsv\GoogleTranslationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LsvGoogleTranslateBundle extends Bundle
{
    public function getPath(): string
    {
        return dirname(__DIR__);
    }
}
