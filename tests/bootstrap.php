<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

$libPath   = realpath(dirname(__FILE__) . '/../lib/');
$testsPath = realpath(dirname(__FILE__) . '/../tests/');
$loader    = require $libPath . '/../vendor/autoload.php';
$loader->add('POTests\\', $testsPath);
