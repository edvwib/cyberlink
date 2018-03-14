<?php

$rules = [
    '@PSR2' => true,
];

$finder = PhpCsFixer\Finder::create()
    ->exclude(['vendor'])
    ->in(__DIR__);

return PhpCsFixer\Config::create()
    ->setRules($rules)
    ->setFinder($finder);
