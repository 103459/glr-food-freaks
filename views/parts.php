<?php
function icon($name, $size = 20)
{
    $paths = [
        'home' => '<path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1z"/>',
        'search' => '<circle cx="10.8" cy="10.8" r="6.7"/><path d="m16 16 5 5"/>',
        'plus' => '<path d="M12 4v16M4 12h16"/>',
        'user' => '<circle cx="12" cy="7.5" r="3.5"/><path d="M5.5 21v-1.5a6.5 6.5 0 0 1 13 0V21"/>',
        'arrow' => '<path d="M4 12h16m-7-7 7 7-7 7"/>',
        'back' => '<path d="M20 12H4m7-7-7 7 7 7"/>',
        'settings' => '<path d="M10.4 3h3.2l.6 2.2 1.9.8 2-.9 2.2 2.2-.9 2 .8 1.9L22 11v3l-2.2.6-.8 1.9.9 2-2.2 2.2-2-.9-1.9.8-.6 2.2h-3.2l-.6-2.2-1.9-.8-2 .9-2.2-2.2.9-2-.8-1.9L2 14v-3l2.2-.6.8-1.9-.9-2 2.2-2.2 2 .9 1.9-.8z"/><circle cx="12" cy="12.5" r="3"/>',
        'camera' => '<path d="M4 7h4l2-2h4l2 2h4v12H4z"/><circle cx="12" cy="13" r="3"/>',
    ];
    return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" '
        . 'stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . ($paths[$name] ?? $paths['plus']) . '</svg>';
}

function recipe_row($listedRecipe)
{
    ?>
    <a class="recipe-row" href="recept_detail.php?ID=<?= (int) $listedRecipe['id'] ?>">
        <img src="<?= e($listedRecipe['image_path']) ?>" alt="<?= e($listedRecipe['title']) ?>" width="160" height="160" loading="lazy">
        <span class="recipe-row-text">
            <strong><?= e($listedRecipe['title']) ?></strong>
            <span><?= (int) $listedRecipe['prep_minutes'] ?> min · <?= e($listedRecipe['difficulty']) ?> · <?= e($listedRecipe['category_name'] ?? '') ?></span>
        </span>
    </a>
    <?php
}

function menu_sheet($categoryOverview)
{
    $menuGroups = [
        'Gangen' => [9, 10, 11],
        'Momenten van de dag' => [1, 2, 3],
        'Extra' => [4, 5, 6, 7, 8],
    ];
    $categoriesById = [];
    foreach ($categoryOverview as $category) {
        $categoriesById[(int) $category['id']] = $category;
    }
    ?>
    <div class="menu-sheet reveal">
        <h2>Het menu</h2>
        <p class="menu-note">Kies een gang, een moment van de dag of iets extra's.</p>
        <?php foreach ($menuGroups as $groupName => $categoryIds): ?>
        <div class="menu-group">
            <h3><?= e($groupName) ?></h3>
            <ul>
                <?php foreach ($categoryIds as $categoryId): ?>
                <?php if (isset($categoriesById[$categoryId])): ?>
                <?php $category = $categoriesById[$categoryId]; ?>
                <li>
                    <a href="recepten.php?category=<?= (int) $category['id'] ?>"><?= e($category['name']) ?></a>
                    <span class="num"><?= (int) $category['recipe_count'] === 0 ? 'nog leeg' : (int) $category['recipe_count'] . ((int) $category['recipe_count'] === 1 ? ' recept' : ' recepten') ?></span>
                </li>
                <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endforeach; ?>
        <p class="menu-end">
            Mis je een gerecht?
            <a href="recept_toevoegen.php">Deel het zelf.</a>
        </p>
    </div>
    <?php
}

function active_nav($navPage, $page)
{
    if ($navPage === $page) {
        return 'active';
    }
    if ($navPage === 'search' && $page === 'recipe') {
        return 'active';
    }
    if ($navPage === 'profile' && in_array($page, ['login', 'register', 'admin'], true)) {
        return 'active';
    }
    return '';
}
