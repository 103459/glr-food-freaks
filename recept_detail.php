<?php
require 'config.php';
$page = 'recipe';

$ID = (int) ($_GET['ID'] ?? 0);
$recipe = recipe_by_id($conn, $ID);

if ($recipe) {
    $title = $recipe['title'];
    $ingredients = ingredient_lines($conn, $ID);
} else {
    $title = 'Recept';
    http_response_code(404);
}

include 'views/recept_detail_view.php';
