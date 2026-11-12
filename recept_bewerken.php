<?php
require 'config.php';
require 'session.inc.php';
$page = 'edit';
$title = 'Recept bewerken';

$ID = (int) ($_GET['ID'] ?? 0);
$recipe = recipe_by_id($conn, $ID);
if (!$recipe || !is_owner_or_admin($recipe, $user)) {
    http_response_code(403);
    exit('Je kunt dit recept niet bewerken.');
}

$ingredients = ingredient_lines($conn, $ID);
$categories = all_categories($conn);
$formAction = 'recept_bewerken_verwerk.php';

include 'views/recept_formulier_view.php';
