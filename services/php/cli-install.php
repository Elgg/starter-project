<?php

$pwd = getenv('ELGG_ADMIN_PASSWORD');
$show_pwd = !$pwd;
if (!$pwd) {
  $pwd = base64_encode(random_bytes(16));
}

// none of the following may be empty
$params = [
  // database parameters
  'dbuser' => getenv('MYSQL_USER'),
  'dbpassword' => getenv('MYSQL_PASSWORD'),
  'dbname' => getenv('MYSQL_DATABASE'),
  'dbprefix' => getenv('ELGG_DB_PREFIX'),
  'dbhost' => getenv('MYSQL_HOST'),
  'dbport' => getenv('MYSQL_PORT') ? : '3306',

  // site settings
  'sitename' => getenv('ELGG_SITE_NAME'),
  'siteemail' => 'fake@example.com',
  'wwwroot' => getenv('ELGG_WWWROOT'),
  'dataroot' => getenv('ELGG_DATAROOT'),

  // admin account
  'displayname' => 'Admin',
  'email' => getenv('ELGG_ADMIN_EMAIL'),
  'username' => getenv('ELGG_ADMIN_USER'),
  'password' => $pwd,
];

if (PHP_SAPI !== 'cli') {
  echo "You must use the command line to run this script.";
  exit;
}

require_once __DIR__ . '/vendor/autoload.php';

$installer = new ElggInstaller();
$installer->batchInstall($params);

echo "\n";
echo "Your sample Elgg site is available at: " . getenv('ELGG_WWWROOT') . "\n\n";
if ($show_pwd) {
  echo "You can log in with " . getenv('ELGG_ADMIN_USER') . " / $pwd\n\n";
}
