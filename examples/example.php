<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use LinkORB\Config\ConfigLoader;
use LinkORB\Config\PostProcessor;

$loader = new ConfigLoader();
$data = $loader->loadFile(__DIR__ . '/config/config.yaml');
print_r($data);


putenv('SHAPE=triangle');
$postProcessor = new PostProcessor();

$data = $postProcessor->process($data, $data);

print_r($data);
