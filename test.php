<?php
require_once './src/index.php';

use jbt\console as Console;
$dev = Console::start();
$live = Console::start('live');
print_r("<pre>");

$dev->log('log message');
$dev->warning('message string','function name','class name');
$dev->dump($dev);
$dev->show();
print_r($dev);
print_r($live);
?>
