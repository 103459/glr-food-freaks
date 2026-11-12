<?php
require_once __DIR__ . '/parts.php';
?>
<!doctype html>
<html lang="nl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#292629">
        <meta name="description" content="GLR Food Freaks helpt je iets lekkers zelf te koken. Vind, bewaar en deel recepten.">
        <title><?= e($title) ?> | GLR Food Freaks</title>
        <link rel="preload" href="assets/fonts/tiktok-sans-latin.woff2" as="font" type="font/woff2" crossorigin>
        <link rel="stylesheet" href="assets/css/style.css">
        <script>document.documentElement.classList.add('js');</script>
        <script src="assets/js/app.js" defer></script>
    </head>
    <body class="page-<?= e($page) ?>">
        <header class="site-header">
            <a class="wordmark" href="index.php">GLR Food Freaks</a>
            <nav class="main-nav" aria-label="Hoofdnavigatie">
                <a href="recepten.php" class="<?= active_nav('search', $page) ?>">Recepten</a>
                <a href="recept_toevoegen.php" class="<?= active_nav('edit', $page) ?>">Deel een recept</a>
            </nav>
            <a class="header-account" href="<?= $user ? 'profiel.php' : 'inloggen.php' ?>"><?= icon('user', 18) ?><span><?= $user ? e($user['username']) : 'Inloggen' ?></span></a>
        </header>

        <main id="main-content">
            <?php if ($melding): ?>
            <div class="notice notice-<?= e($melding['type']) ?>" role="status"><?= e($melding['message']) ?></div>
            <?php endif; ?>
