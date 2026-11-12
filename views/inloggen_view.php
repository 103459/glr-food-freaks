<?php include __DIR__ . '/header.php'; ?>
<section class="auth">
    <div class="auth-side">
        <img src="assets/tacos.png" alt="Smashed taco tortilla's met kaas en koriander" width="1448" height="1086">
        <h2 class="auth-big">Van kijken naar koken</h2>
        <p>Je recepten en favorieten staan klaar.</p>
    </div>
    <div class="auth-form">
        <h1>Inloggen</h1>
        <form method="post" action="inloggen_verwerk.php" class="form-stack">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <label>
                E-mailadres
                <input type="email" name="email" value="<?= e(form_value('email')) ?>" autocomplete="email" required>
            </label>
            <label>
                Wachtwoord
                <input type="password" name="password" autocomplete="current-password" required>
            </label>
            <button class="btn btn-accent btn-bar" type="submit">Inloggen</button>
        </form>
        <p class="auth-switch">Nog geen account? <a href="registreren.php">Account aanmaken</a></p>
    </div>
</section>
<?php include __DIR__ . '/footer.php'; ?>
