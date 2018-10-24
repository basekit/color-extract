<?php
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

$app = new Application();
$command = new \Robjmills\ColorExtract\ExtractCommand();
$app->add($command);
$app->setDefaultCommand($command->getName());

try {
    $app->run();
} catch (Exception $e) {
    return $e->getMessage();
}