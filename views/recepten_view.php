<?php include __DIR__ . '/header.php'; ?>
<section class="page-intro">
    <h1>Recepten</h1>
    <p class="lead">Zoek op ingrediënt of gerecht en kies een soort gerecht.</p>
</section>
<form class="search-panel" action="recepten.php#resultaten" method="get">
    <div class="search-line">
        <label class="visually-hidden" for="search-q">Zoek recepten of ingrediënten</label>
        <input id="search-q" type="search" name="q" value="<?= e($search) ?>" placeholder="Bijv. kikkererwten of pasta">
        <button class="btn btn-accent" type="submit">Zoeken</button>
    </div>
    <div class="filters">
        <label>
            Categorie
            <select name="category">
                <option value="0">Alles</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?= (int) $category['id'] ?>" <?= $categoryId === (int) $category['id'] ? 'selected' : '' ?>><?= e($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button class="btn btn-ink" type="submit">Filteren</button>
    </div>
</form>
<section class="results" id="resultaten">
    <h2><?= count($recipes) ?> <?= count($recipes) === 1 ? 'recept' : 'recepten' ?> gevonden</h2>
    <?php if ($recipes): ?>
    <div class="recipe-list">
        <?php foreach ($recipes as $listedRecipe): ?>
        <?php recipe_row($listedRecipe); ?>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <h3>Nog niets gevonden</h3>
        <p>Probeer een ander ingrediënt of een andere categorie. Of deel als eerste een recept dat hier past.</p>
        <div class="empty-actions">
            <a class="btn btn-ink" href="recepten.php">Alle recepten</a>
            <a class="btn btn-accent" href="recept_toevoegen.php">Recept delen</a>
        </div>
    </div>
    <?php endif; ?>
</section>
<?php include __DIR__ . '/footer.php'; ?>
