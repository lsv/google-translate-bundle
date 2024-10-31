<?php

declare(strict_types=1);

use Ergebnis\License;

$license = License\Type\MIT::text(
    __DIR__.'/LICENSE',
    License\Range::since(
        License\Year::fromString('2024'),
        new DateTimeZone('UTC')
    ),
    License\Holder::fromString('Martin Aarhof'),
    License\Url::fromString('https://github.com/lsv/google-translate-bundle/blob/master/LICENSE')
);

$license->save();

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('var')
;

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@Symfony' => true,
    'strict_param' => true,
    'array_syntax' => ['syntax' => 'short'],
    '@PHP80Migration:risky' => true,
    'php_unit_construct' => true,
    'php_unit_strict' => true,
    'header_comment' => [
        'comment_type' => 'PHPDoc',
        'header' => $license->header(),
        'location' => 'after_declare_strict',
        'separate' => 'both',
    ],
])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
