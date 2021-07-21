<?php

$paths  = [
    __DIR__ . '/src',
    __DIR__ . '/tests',
];
$finder = \PhpCsFixer\Finder::create()->in($paths);
$config = new PhpCsFixer\Config();

return $config->setFinder($finder);
