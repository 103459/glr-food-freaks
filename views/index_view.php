<?php include __DIR__ . '/header.php'; ?>
<section class="drop-hero">
    <h1 class="drop-wordmark">GLR Food Freaks</h1>
    <div class="drop-bar">
        <p class="drop-sentence">Recepten om vandaag zelf te koken.</p>
        <div class="drop-rows">
            <?php foreach ($recipes as $slideIndex => $listedRecipe): ?>
            <div class="drop-row drop-slide <?= $slideIndex === $featuredIndex ? 'is-shown' : '' ?>" data-slide="<?= $slideIndex ?>">
                <span><?= (int) $listedRecipe['prep_minutes'] ?> min · <?= (int) $listedRecipe['servings'] ?> personen</span>
                <a class="btn btn-accent" href="recept_detail.php?ID=<?= (int) $listedRecipe['id'] ?>"><?= e($listedRecipe['title']) ?></a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <form class="search-line hero-search" action="recepten.php#resultaten" method="get">
        <label class="visually-hidden" for="hero-search">Zoek op ingrediënt of gerecht</label>
        <input id="hero-search" name="q" type="search" placeholder="Zoek op ingrediënt">
        <button class="btn btn-accent" type="submit">Zoeken</button>
    </form>
    <div class="drop-photos">
        <?php foreach ($recipes as $slideIndex => $listedRecipe): ?>
        <img class="drop-slide <?= $slideIndex === $featuredIndex ? 'is-shown' : '' ?>" data-slide="<?= $slideIndex ?>" src="<?= e($listedRecipe['image_path']) ?>" alt="<?= e($listedRecipe['title']) ?>" width="1600" height="700">
        <?php endforeach; ?>
    </div>
</section>

<section class="home-search">
    <div class="home-search-text reveal">
        <h2>Wat heb je in huis?</h2>
        <p>Zoek op wat er nog in je koelkast ligt en zie meteen wat je kunt maken.</p>
        <form class="search-line" action="recepten.php#resultaten" method="get">
            <label class="visually-hidden" for="home-search">Zoek op ingrediënt of gerecht</label>
            <input id="home-search" name="q" type="search" placeholder="Bijv. kikkererwten of pasta">
            <button class="btn btn-ink" type="submit">Zoeken</button>
        </form>
    </div>
</section>

<?php if (count($quickRecipes) === 2): ?>
<section class="two-fields">
    <?php foreach ($quickRecipes as $fieldIndex => $listedRecipe): ?>
    <article class="field field-<?= $fieldIndex === 0 ? 'paper' : 'dark' ?>">
        <?php if ($fieldIndex === 0): ?>
        <h2 class="reveal">Snelst op tafel</h2>
        <?php endif; ?>
        <img class="reveal" src="<?= e($listedRecipe['image_path']) ?>" alt="<?= e($listedRecipe['title']) ?>" width="900" height="700" loading="lazy">
        <div class="field-row">
            <p>
                <strong><?= e($listedRecipe['title']) ?></strong>
                <span><?= (int) $listedRecipe['prep_minutes'] ?> min · <?= e($listedRecipe['difficulty']) ?></span>
            </p>
            <a class="btn <?= $fieldIndex === 0 ? 'btn-ink' : 'btn-paper' ?>" href="recept_detail.php?ID=<?= (int) $listedRecipe['id'] ?>">Bekijk recept</a>
        </div>
    </article>
    <?php endforeach; ?>
</section>
<?php endif; ?>

<section class="menu-band">
    <?php menu_sheet($categoryOverview); ?>
</section>

<section class="statement">
    <h2 class="statement-title reveal">
        Stop de
        <span>ontkoking</span>
    </h2>
    <div class="prints">
        <?php foreach (array_slice($recipes, 0, 2) as $printIndex => $listedRecipe): ?>
        <a class="print print-<?= $printIndex + 1 ?>" href="recept_detail.php?ID=<?= (int) $listedRecipe['id'] ?>">
            <img src="<?= e($listedRecipe['image_path']) ?>" alt="<?= e($listedRecipe['title']) ?>" width="480" height="640" loading="lazy">
        </a>
        <?php endforeach; ?>
    </div>
    <p class="statement-text reveal">Jongeren koken steeds minder en bestellen vaker. GLR Food Freaks maakt beginnen makkelijk: korte recepten, duidelijke stappen en recepten van andere studenten.</p>
</section>

<section class="reply">
    <p class="reply-text reveal">Heb jij iets lekkers gemaakt? Laat de rest zien hoe je het doet.</p>
    <div class="reply-card reveal">
        <h2>Deel jouw recept</h2>
        <p>Een foto, je ingrediënten en de stappen. Dan kan iedereen het namaken.</p>
        <a class="btn btn-ink btn-bar" href="recept_toevoegen.php">Recept delen</a>
    </div>
</section>
<?php include __DIR__ . '/footer.php'; ?>
