<?php
require 'config.php';
$page = 'search';
$title = 'Recepten zoeken';

$search = trim((string) ($_GET['q'] ?? ''));
$categoryId = (int) ($_GET['category'] ?? 0);

$categories = all_categories($conn);
$recipes = list_recipes($conn, $search, $categoryId, 40);

include 'views/recepten_view.php';
