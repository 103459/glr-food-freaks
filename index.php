<?php
require 'config.php';
$page = 'home';
$title = 'Recepten om zelf te koken';

$recipes = list_recipes($conn, '', 0, 4);
$featuredIndex = 0;
if (count($recipes) > 0) {
    $featuredIndex = date('z') % count($recipes);
}

$quickRecipes = $conn->query('SELECT * FROM recipes ORDER BY prep_minutes, id LIMIT 2')->fetchAll();

$categoryOverview = category_overview($conn);

include 'views/index_view.php';
