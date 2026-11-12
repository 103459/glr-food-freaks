<?php
require 'config.php';
check_csrf();
require 'session.inc.php';

$oldRecipe = null;
$backTo = 'recept_toevoegen.php';
require 'recept_controleren.inc.php';

$stmt = $conn->prepare('INSERT INTO recipes (user_id, category_id, title, summary, instructions, prep_minutes, servings, difficulty, image_path)
                        VALUES (:user, :category, :title, :summary, :instructions, :minutes, :servings, :difficulty, :image)');
$stmt->execute([
    ':user' => $user['id'],
    ':category' => $categoryId,
    ':title' => $recipeTitle,
    ':summary' => $summary,
    ':instructions' => $instructions,
    ':minutes' => $prepMinutes,
    ':servings' => $servings,
    ':difficulty' => $difficulty,
    ':image' => $imagePath,
]);
$ID = (int) $conn->lastInsertId();

$stmt = $conn->prepare('INSERT INTO recipe_ingredients (recipe_id, ingredient_line, position) VALUES (:recipe, :line, :position)');
$position = 1;
foreach ($ingredients as $ingredientLine) {
    $stmt->execute([':recipe' => $ID, ':line' => $ingredientLine, ':position' => $position]);
    $position++;
}

melding('success', 'Je recept staat online!');
header('Location: recept_detail.php?ID=' . $ID);
exit;
