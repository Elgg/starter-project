<?php

$autoload_path = '/vendor/autoload.php';
$autoload_available = include_once($autoload_path);
if (!$autoload_available) {
	die("Couldn't include '$autoload_path'. Did you run `composer install`?");
}

$app = new \Elgg\Application();

return $app->run();
