<?php include __DIR__ . '/header.php'; ?>
<section class="app-title">
    <div>
        <h1><?= e($user['username']) ?></h1>
        <p><?= count($myRecipes) ?> <?= count($myRecipes) === 1 ? 'eigen recept' : 'eigen recepten' ?></p>
    </div>
    <div class="app-title-actions">
        <?php if ($user['role'] === 'admin'): ?>
        <a class="btn btn-paper" href="beheer.php"><?= icon('settings', 18) ?> Beheer</a>
        <?php endif; ?>
        <a class="btn btn-accent" href="recept_toevoegen.php"><?= icon('plus', 18) ?> Recept toevoegen</a>
    </div>
</section>
<section class="tab-panel">
    <h2 class="visually-hidden">Mijn recepten</h2>
    <?php if ($myRecipes): ?>
    <div class="manage-list">
        <?php foreach ($myRecipes as $listedRecipe): ?>
        <div class="manage-row">
            <a href="recept_detail.php?ID=<?= (int) $listedRecipe['id'] ?>">
                <img src="<?= e($listedRecipe['image_path']) ?>" alt="" width="64" height="64">
                <span>
                    <strong><?= e($listedRecipe['title']) ?></strong>
                    <small><?= (int) $listedRecipe['prep_minutes'] ?> min · <?= e($listedRecipe['category_name']) ?></small>
                </span>
            </a>
            <div class="manage-actions">
                <a href="recept_bewerken.php?ID=<?= (int) $listedRecipe['id'] ?>">Wijzigen</a>
                <a href="recept_verwijderen.php?ID=<?= (int) $listedRecipe['id'] ?>">Verwijderen</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty-state">
        <h3>Deel je eerste recept</h3>
        <p>Je eigen recepten verschijnen hier, zodat je ze kunt wijzigen of verwijderen.</p>
        <a class="btn btn-accent" href="recept_toevoegen.php">Recept toevoegen</a>
    </div>
    <?php endif; ?>
</section>
<form method="post" action="loguit.php" class="logout">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <button class="text-button" type="submit">Uitloggen</button>
</form>
<?php include __DIR__ . '/footer.php'; ?>
