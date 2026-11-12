<?php include __DIR__ . '/header.php'; ?>
<section class="page-intro">
    <h1>Recept verwijderen</h1>
    <p class="lead">Weet je het zeker? Dit recept wordt voorgoed verwijderd, met de ingrediënten en de foto.</p>
</section>
<section class="results">
    <div class="recipe-list">
        <?php recipe_row($recipe); ?>
    </div>
    <div class="detail-actions">
        <form method="post" action="recept_verwijderen_verwerk.php">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <input type="hidden" name="ID" value="<?= (int) $recipe['id'] ?>">
            <button class="btn btn-danger" type="submit">Ja, verwijderen</button>
        </form>
        <a class="btn btn-paper" href="recept_detail.php?ID=<?= (int) $recipe['id'] ?>">Nee, terug naar het recept</a>
    </div>
</section>
<?php include __DIR__ . '/footer.php'; ?>
