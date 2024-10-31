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
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class LsvGoogleTranslateBundleTestingKernel extends Kernel
{
    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function registerBundles(): iterable
    {
        return [
            new LsvGoogleTranslateBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
    }

    public function getCacheDir(): string
    {
        return __DIR__.'/../var/cache/'.spl_object_hash($this);
    }
}
