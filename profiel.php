<?php
require 'config.php';
require 'session.inc.php';
$page = 'profile';
$title = 'Mijn profiel';

$stmt = $conn->prepare('SELECT r.*, c.name AS category_name FROM recipes r
                        JOIN categories c ON c.id = r.category_id
                        WHERE r.user_id = :user ORDER BY r.created_at DESC');
$stmt->execute([':user' => $user['id']]);
$myRecipes = $stmt->fetchAll();

include 'views/profiel_view.php';
