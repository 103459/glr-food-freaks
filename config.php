<?php
session_start();

$settings = require __DIR__ . '/config/config.php';
$db_hostname = $settings['db_host'];
$db_port = $settings['db_port'];
$db_database = $settings['db_name'];
$db_username = $settings['db_user'];
$db_password = $settings['db_pass'];

require __DIR__ . '/functions.php';

try {
    $conn = new PDO("mysql:host=$db_hostname;port=$db_port;dbname=$db_database;charset=utf8mb4", $db_username, $db_password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    exit('Geen verbinding met de database. Importeer database/schema.sql en vul de gegevens in config/config.php of config/config.local.php in.');
}

$user = current_user($conn);

$melding = $_SESSION['melding'] ?? null;
$old = $_SESSION['old'] ?? [];
unset($_SESSION['melding'], $_SESSION['old']);
