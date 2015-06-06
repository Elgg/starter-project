<?php

$autoload_path = __DIR__ . '/vendor/autoload.php';
if (!include_once($autoload_path)) {
	die("Couldn't include '$autoload_path'. Did you run `composer install`?");
}

\Elgg\Application::index(__DIR__);
