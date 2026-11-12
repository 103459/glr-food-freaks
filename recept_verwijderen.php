<?php
require 'config.php';
require 'session.inc.php';
$page = 'profile';
$title = 'Recept verwijderen';

$ID = (int) ($_GET['ID'] ?? 0);
$recipe = recipe_by_id($conn, $ID);
if (!$recipe || !is_owner_or_admin($recipe, $user)) {
    http_response_code(403);
    exit('Je kunt dit recept niet verwijderen.');
}

include 'views/recept_verwijderen_view.php';
