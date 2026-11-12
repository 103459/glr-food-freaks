<?php include __DIR__ . '/header.php'; ?>
<section class="page-intro">
    <h1><?= $recipe ? 'Recept bewerken' : 'Deel jouw recept' ?></h1>
    <p class="lead">Laat zien wat jij graag op tafel zet. Eén ingrediënt en één stap per regel.</p>
</section>
<form method="post" action="<?= $formAction ?>" enctype="multipart/form-data" class="recipe-form">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="ID" value="<?= (int) ($recipe['id'] ?? 0) ?>">
    <div class="form-photo">
        <label for="recipe-image">Foto van je gerecht</label>
        <img id="image-preview" src="<?= $recipe ? e($recipe['image_path']) : '' ?>" alt="Voorbeeld van je foto" width="480" height="480" <?= $recipe ? '' : 'hidden' ?>>
        <input id="recipe-image" type="file" name="image" accept="image/jpeg,image/png,image/webp" data-image-preview>
        <small>JPG, PNG of WebP, maximaal 3 MB. Gaat er iets mis bij het opslaan? Kies de foto dan opnieuw.</small>
    </div>
    <div class="form-grid">
        <label class="full-width">
            Titel
            <input type="text" name="title" value="<?= e(form_value('title', $recipe['title'] ?? '')) ?>" maxlength="150" minlength="3" required>
        </label>
        <label>
            Categorie
            <select name="category_id" required>
                <option value="">Kies een categorie</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?= (int) $category['id'] ?>" <?= (int) form_value('category_id', (string) ($recipe['category_id'] ?? 0)) === (int) $category['id'] ? 'selected' : '' ?>><?= e($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>
            Niveau
            <select name="difficulty">
                <?php foreach ($difficultyOptions as $difficultyOption): ?>
                <option <?= form_value('difficulty', $recipe['difficulty'] ?? '') === $difficultyOption ? 'selected' : '' ?>><?= e($difficultyOption) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="full-width">
            Korte beschrijving
            <input type="text" name="summary" value="<?= e(form_value('summary', $recipe['summary'] ?? '')) ?>" maxlength="300" minlength="8" required>
        </label>
        <label>
            Bereidingstijd in minuten
            <input type="number" name="prep_minutes" value="<?= e(form_value('prep_minutes', (string) ($recipe['prep_minutes'] ?? 15))) ?>" min="1" max="600" required>
        </label>
        <label>
            Aantal personen
            <input type="number" name="servings" value="<?= e(form_value('servings', (string) ($recipe['servings'] ?? 2))) ?>" min="1" max="20" required>
        </label>
        <label class="full-width">
            Ingrediënten, één per regel
            <textarea name="ingredients" rows="6" required><?= e(form_value('ingredients', implode("\n", $ingredients))) ?></textarea>
        </label>
        <label class="full-width">
            Bereidingsstappen, één per regel
            <textarea name="instructions" rows="7" required><?= e(form_value('instructions', $recipe['instructions'] ?? '')) ?></textarea>
        </label>
    </div>
    <button class="btn btn-accent btn-bar" type="submit"><?= $recipe ? 'Wijzigingen opslaan' : 'Recept publiceren' ?></button>
</form>
<?php include __DIR__ . '/footer.php'; ?>
