<?php
require 'config.php';
require 'session.inc.php';

if ($user['role'] !== 'admin') {
    http_response_code(403);
    exit('Je hebt geen toegang tot dit onderdeel.');
}
$page = 'admin';
$title = 'Beheer';

$allRecipes = list_recipes($conn, '', 0, 100);
$users = $conn->query('SELECT id, username, email, role, is_active FROM users ORDER BY created_at DESC')->fetchAll();

include 'views/beheer_view.php';
