<?php
require 'config.php';
check_csrf();
require 'session.inc.php';

$ID = (int) ($_POST['ID'] ?? 0);
$oldRecipe = recipe_by_id($conn, $ID);
if (!$oldRecipe || !is_owner_or_admin($oldRecipe, $user)) {
    terug_met_fout('Je kunt dit recept niet bewerken.', 'index.php');
}

$backTo = 'recept_bewerken.php?ID=' . $ID;
require 'recept_controleren.inc.php';

$stmt = $conn->prepare('UPDATE recipes SET category_id = :category, title = :title, summary = :summary, instructions = :instructions,
                        prep_minutes = :minutes, servings = :servings, difficulty = :difficulty, image_path = :image
                        WHERE id = :id');
$stmt->execute([
    ':category' => $categoryId,
    ':title' => $recipeTitle,
    ':summary' => $summary,
    ':instructions' => $instructions,
    ':minutes' => $prepMinutes,
    ':servings' => $servings,
    ':difficulty' => $difficulty,
    ':image' => $imagePath,
    ':id' => $ID,
]);

$stmt = $conn->prepare('DELETE FROM recipe_ingredients WHERE recipe_id = :id');
$stmt->execute([':id' => $ID]);
$stmt = $conn->prepare('INSERT INTO recipe_ingredients (recipe_id, ingredient_line, position) VALUES (:recipe, :line, :position)');
$position = 1;
foreach ($ingredients as $ingredientLine) {
    $stmt->execute([':recipe' => $ID, ':line' => $ingredientLine, ':position' => $position]);
    $position++;
}

if ($imagePath !== $oldRecipe['image_path']) {
    delete_uploaded_image($oldRecipe['image_path']);
}

melding('success', 'Recept bijgewerkt.');
header('Location: recept_detail.php?ID=' . $ID);
exit;
