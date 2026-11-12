<?php include __DIR__ . '/header.php'; ?>
<section class="auth">
    <div class="auth-side">
        <img src="assets/tacos.png" alt="Smashed taco tortilla's met kaas en koriander" width="1448" height="1086">
        <h2 class="auth-big">Welkom in de keuken</h2>
        <p>Met een account deel je recepten en bewaar je favorieten.</p>
    </div>
    <div class="auth-form">
        <h1>Account maken</h1>
        <form method="post" action="registreren_verwerk.php" class="form-stack">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <label>
                Gebruikersnaam
                <input type="text" name="username" value="<?= e(form_value('username')) ?>" autocomplete="username" minlength="3" maxlength="40" pattern="[A-Za-z0-9_.\-]{3,40}" title="3 tot 40 tekens: letters, cijfers, punt, streepje of liggend streepje, zonder spaties" required>
                <small>3 tot 40 tekens: letters, cijfers, punt, streepje of liggend streepje, zonder spaties.</small>
            </label>
            <label>
                E-mailadres
                <input type="email" name="email" value="<?= e(form_value('email')) ?>" autocomplete="email" required>
            </label>
            <label>
                Wachtwoord
                <input type="password" name="password" autocomplete="new-password" minlength="8" required>
                <small>Minimaal 8 tekens.</small>
            </label>
            <button class="btn btn-accent btn-bar" type="submit">Account maken</button>
        </form>
        <p class="auth-switch">Al een account? <a href="inloggen.php">Inloggen</a></p>
    </div>
</section>
<?php include __DIR__ . '/footer.php'; ?>
