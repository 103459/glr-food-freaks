<?php
require 'config.php';
check_csrf();
require 'session.inc.php';

$ID = (int) ($_POST['ID'] ?? 0);
$recipe = recipe_by_id($conn, $ID);
if (!$recipe || !is_owner_or_admin($recipe, $user)) {
    terug_met_fout('Je kunt dit recept niet verwijderen.', 'index.php');
}

$stmt = $conn->prepare('DELETE FROM recipes WHERE id = :id');
$stmt->execute([':id' => $ID]);
delete_uploaded_image($recipe['image_path']);

melding('success', 'Recept verwijderd.');
if ($user['role'] === 'admin') {
    header('Location: beheer.php');
} else {
    header('Location: profiel.php');
}
exit;
