        </main>

        <footer class="site-footer">
            <div class="footer-card">
                <div class="footer-message">
                    <p class="footer-signoff">Tot in de keuken</p>
                    <p>GLR Food Freaks is een schoolproject van studenten van het Grafisch Lyceum Rotterdam, gemaakt voor de opdracht Stop de ontkoking.</p>
                </div>
                <nav class="footer-links" aria-label="Voettekst">
                    <img class="footer-stamp" src="assets/pancakes.jpg" alt="" width="88" height="117" loading="lazy">
                    <a href="recepten.php">Recepten zoeken</a>
                    <a href="recept_toevoegen.php">Deel een recept</a>
                    <a href="<?= $user ? 'profiel.php' : 'inloggen.php' ?>"><?= $user ? 'Mijn profiel' : 'Inloggen' ?></a>
                </nav>
                <p class="footer-imprint">© <?= date('Y') ?> GLR Food Freaks · Lettertype TikTok Sans (SIL Open Font License) · Maker en licentie van foto's uit open collecties staan bij het recept</p>
            </div>
        </footer>

        <nav class="mobile-nav" aria-label="Mobiele navigatie">
            <a href="index.php" class="<?= active_nav('home', $page) ?>"><?= icon('home', 22) ?><span>Home</span></a>
            <a href="recepten.php" class="<?= active_nav('search', $page) ?>"><?= icon('search', 22) ?><span>Zoeken</span></a>
            <a href="recept_toevoegen.php" class="<?= active_nav('edit', $page) ?>"><?= icon('plus', 22) ?><span>Delen</span></a>
            <a href="<?= $user ? 'profiel.php' : 'inloggen.php' ?>" class="<?= active_nav('profile', $page) ?>"><?= icon('user', 22) ?><span>Profiel</span></a>
        </nav>
    </body>
</html>
