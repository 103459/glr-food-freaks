<?php
$recipeTitle = trim((string) ($_POST['title'] ?? ''));
$summary = trim((string) ($_POST['summary'] ?? ''));
$instructions = trim((string) ($_POST['instructions'] ?? ''));
$categoryId = (int) ($_POST['category_id'] ?? 0);
$prepMinutes = (int) ($_POST['prep_minutes'] ?? 0);
$servings = (int) ($_POST['servings'] ?? 0);
$difficulty = (string) ($_POST['difficulty'] ?? '');
$ingredients = text_lines((string) ($_POST['ingredients'] ?? ''));

$stmt = $conn->prepare('SELECT id FROM categories WHERE id = :id');
$stmt->execute([':id' => $categoryId]);
$categoryExists = $stmt->fetch();

$tooLongLine = false;
foreach ($ingredients as $ingredientLine) {
    if (mb_strlen($ingredientLine) > 200) {
        $tooLongLine = true;
    }
}

$photo = $_FILES['image'] ?? null;
$hasPhoto = $photo !== null && $photo['error'] !== UPLOAD_ERR_NO_FILE;
$photoTypes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
$photoType = '';
if ($hasPhoto && $photo['error'] === UPLOAD_ERR_OK) {
    $photoType = mime_content_type($photo['tmp_name']);
}

$error = '';
if (mb_strlen($recipeTitle) < 3 || mb_strlen($recipeTitle) > 150) {
    $error = 'Gebruik een titel van 3 tot 150 tekens.';
} elseif (mb_strlen($summary) < 8 || mb_strlen($summary) > 300) {
    $error = 'Gebruik een beschrijving van 8 tot 300 tekens.';
} elseif (mb_strlen($instructions) < 15) {
    $error = 'Beschrijf de bereiding in minimaal 15 tekens.';
} elseif (!$categoryExists) {
    $error = 'Kies een bestaande categorie.';
} elseif ($prepMinutes < 1 || $prepMinutes > 600) {
    $error = 'Kies een bereidingstijd van 1 tot 600 minuten.';
} elseif ($servings < 1 || $servings > 20) {
    $error = 'Kies 1 tot 20 personen.';
} elseif (!in_array($difficulty, $difficultyOptions)) {
    $error = 'Kies een geldige moeilijkheid.';
} elseif (count($ingredients) < 1 || count($ingredients) > 30) {
    $error = 'Vul 1 tot 30 ingrediënten in.';
} elseif ($tooLongLine) {
    $error = 'Houd elke ingrediëntenregel onder 200 tekens.';
} elseif ($hasPhoto && ($photo['error'] !== UPLOAD_ERR_OK || $photo['size'] > 3 * 1024 * 1024)) {
    $error = 'Kies een afbeelding kleiner dan 3 MB.';
} elseif ($hasPhoto && !isset($photoTypes[$photoType])) {
    $error = 'Gebruik een JPG, PNG of WebP afbeelding.';
}
if ($error !== '') {
    if ($hasPhoto) {
        $error .= ' Kies de foto opnieuw voordat je het recept opslaat.';
    }
    terug_met_fout($error, $backTo);
}

$imagePath = $oldRecipe ? $oldRecipe['image_path'] : 'assets/geen-foto.svg';
if ($hasPhoto) {
    $imagePath = 'uploads/' . bin2hex(random_bytes(16)) . '.' . $photoTypes[$photoType];
    if (!move_uploaded_file($photo['tmp_name'], __DIR__ . '/' . $imagePath)) {
        terug_met_fout('De foto kon niet worden opgeslagen.', $backTo);
    }
}
