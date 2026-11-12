<?php
include __DIR__ . '/header.php';

$photoCredits = [
    'assets/hummus.jpg' => 'Nilo Velez, CC0, via WordPress Photo Directory',
    'assets/gebakken-rijst.jpg' => 'Tofu fighting, CC BY-SA 4.0, via Wikimedia Commons',
    'assets/tosti.jpg' => 'U.S. Department of Agriculture, CC0, via rawpixel',
    'assets/overnight-oats.jpg' => 'Kolforn, CC BY-SA 4.0, via Wikimedia Commons',
    'assets/salade.jpg' => 'jeffreyw, CC BY 2.0, via Wikimedia Commons',
    'assets/yoghurt-fruit.jpg' => 'Average Jane, CC BY 2.0, via Flickr',
];
?>
<?php if ($recipe): ?>
<article class="recipe-detail">
    <div class="detail-media">
        <img src="<?= e($recipe['image_path']) ?>" alt="<?= e($recipe['title']) ?>" width="900" height="900">
        <?php if (isset($photoCredits[$recipe['image_path']])): ?>
        <p class="photo-credit">Foto: <?= e($photoCredits[$recipe['image_path']]) ?></p>
        <?php endif; ?>
    </div>
    <div class="detail-content">
        <a class="back-link" href="recepten.php"><?= icon('back', 18) ?> Alle recepten</a>
        <p class="detail-kicker"><?= e($recipe['category_name']) ?> · door <?= e($recipe['author_name']) ?></p>
        <h1><?= e($recipe['title']) ?></h1>
        <p class="lead"><?= e($recipe['summary']) ?></p>
        <dl class="stats">
            <div>
                <dt>Tijd</dt>
                <dd class="num"><?= (int) $recipe['prep_minutes'] ?> min</dd>
            </div>
            <div>
                <dt>Personen</dt>
                <dd class="num"><?= (int) $recipe['servings'] ?></dd>
            </div>
            <div>
                <dt>Niveau</dt>
                <dd><?= e($recipe['difficulty']) ?></dd>
            </div>
        </dl>
        <div class="detail-actions">
            <?php if (is_owner_or_admin($recipe, $user)): ?>
            <a class="btn btn-ink" href="recept_bewerken.php?ID=<?= (int) $recipe['id'] ?>">Bewerken</a>
            <?php endif; ?>
            <a class="btn btn-paper" href="https://wa.me/?text=<?= rawurlencode($recipe['title'] . ' op GLR Food Freaks: ' . current_url()) ?>" target="_blank" rel="noopener">Deel via WhatsApp</a>
            <button class="btn btn-paper" type="button" data-copy-link>Kopieer link</button>
        </div>
        <div class="tabs" data-tabs>
            <button class="tab-button is-active" data-tab="ingredients" type="button">Ingrediënten (<?= count($ingredients) ?>)</button>
            <button class="tab-button" data-tab="steps" type="button">Bereiding</button>
        </div>
        <section class="tab-panel" data-panel="ingredients">
            <h2>Dit heb je nodig</h2>
            <ul class="ingredient-list">
                <?php foreach ($ingredients as $ingredientLine): ?>
                <li><?= e($ingredientLine) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
        <section class="tab-panel" data-panel="steps" hidden>
            <h2>Zo maak je het</h2>
            <ol class="step-list">
                <?php foreach (text_lines($recipe['instructions']) as $step): ?>
                <li><?= e($step) ?></li>
                <?php endforeach; ?>
            </ol>
        </section>
        <?php if (is_owner_or_admin($recipe, $user)): ?>
        <div class="owner-actions">
            <a class="btn btn-paper" href="recept_bewerken.php?ID=<?= (int) $recipe['id'] ?>">Bewerken</a>
            <a class="btn btn-danger" href="recept_verwijderen.php?ID=<?= (int) $recipe['id'] ?>">Verwijderen</a>
        </div>
        <?php endif; ?>
    </div>
</article>
<?php else: ?>
<section class="page-intro">
    <h1>Recept niet gevonden</h1>
    <p class="lead">Dit recept bestaat niet of is verwijderd.</p>
    <a class="btn btn-accent" href="recepten.php">Bekijk alle recepten</a>
</section>
<?php endif; ?>
<?php include __DIR__ . '/footer.php'; ?>
