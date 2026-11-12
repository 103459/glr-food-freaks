<?php
require 'config.php';
require 'session.inc.php';
$page = 'edit';
$title = 'Recept delen';

$recipe = null;
$ingredients = [];
$categories = all_categories($conn);
$formAction = 'recept_toevoegen_verwerk.php';

include 'views/recept_formulier_view.php';
