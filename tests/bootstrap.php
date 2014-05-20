<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

echo "\n", '############################################################', "\n";
echo       "# Testing...                                               #";
echo "\n", '############################################################', "\n";
echo "\n";
system('clear');
$libPath   = realpath(dirname(__FILE__) . '/../lib/');
$testsPath = realpath(dirname(__FILE__) . '/../tests/');
$loader    = require $libPath . '/../vendor/autoload.php';
$loader->add('POTests\\', $testsPath);
$loader->add('PO\\', $libPath);
