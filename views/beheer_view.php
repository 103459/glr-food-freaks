<?php include __DIR__ . '/header.php'; ?>
<section class="app-title">
    <div>
        <h1>Beheer</h1>
        <p><?= count($allRecipes) ?> <?= count($allRecipes) === 1 ? 'recept' : 'recepten' ?> · <?= count($users) ?> <?= count($users) === 1 ? 'gebruiker' : 'gebruikers' ?></p>
    </div>
</section>
<div class="admin-columns">
    <section class="panel">
        <h2>Recepten</h2>
        <div class="manage-list">
            <?php foreach ($allRecipes as $listedRecipe): ?>
            <div class="manage-row">
                <a href="recept_detail.php?ID=<?= (int) $listedRecipe['id'] ?>">
                    <img src="<?= e($listedRecipe['image_path']) ?>" alt="" width="64" height="64">
                    <span>
                        <strong><?= e($listedRecipe['title']) ?></strong>
                        <small><?= e($listedRecipe['author_name']) ?> · <?= e($listedRecipe['category_name']) ?></small>
                    </span>
                </a>
                <div class="manage-actions">
                    <a href="recept_bewerken.php?ID=<?= (int) $listedRecipe['id'] ?>">Aanpassen</a>
                    <a href="recept_verwijderen.php?ID=<?= (int) $listedRecipe['id'] ?>">Verwijderen</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="panel">
        <h2>Gebruikers</h2>
        <div class="manage-list">
            <?php foreach ($users as $account): ?>
            <div class="manage-row">
                <span class="user-cell">
                    <span class="user-badge"><?= e(mb_strtoupper(mb_substr($account['username'], 0, 1))) ?></span>
                    <span>
                        <strong><?= e($account['username']) ?></strong>
                        <small><?= e($account['email']) ?> · <?= e($account['role']) ?><?= $account['is_active'] ? '' : ' · uitgeschakeld' ?></small>
                    </span>
                </span>
                <div class="manage-actions">
                    <?php if ((int) $account['id'] !== (int) $user['id']): ?>
                    <form method="post" action="gebruiker_status_verwerk.php">
                        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                        <input type="hidden" name="ID" value="<?= (int) $account['id'] ?>">
                        <button type="submit"><?= $account['is_active'] ? 'Deactiveren' : 'Activeren' ?></button>
                    </form>
                    <?php else: ?>
                    <span>Jij</span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>
<?php include __DIR__ . '/footer.php'; ?>
