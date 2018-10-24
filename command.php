<?php
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

$app = new Application();
$app->add(new \Robjmills\ColorExtract\ExtractCommand());
try {
    $app->run();
} catch (Exception $e) {
    return $e->getMessage();
}