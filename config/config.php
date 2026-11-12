<?php
declare(strict_types=1);

$databaseSettings = [
    'db_host' => '127.0.0.1',
    'db_port' => '3306',
    'db_name' => 'stop_de_ontkoking',
    'db_user' => 'root',
    'db_pass' => '',
];

$localConfigPath = __DIR__ . '/config.local.php';
if (is_file($localConfigPath)) {
    $databaseSettings = array_replace($databaseSettings, require $localConfigPath);
}

return $databaseSettings;
