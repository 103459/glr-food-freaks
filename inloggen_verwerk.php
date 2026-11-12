<?php
require 'config.php';
check_csrf();

$email = strtolower(trim((string) ($_POST['email'] ?? '')));
$password = (string) ($_POST['password'] ?? '');

$stmt = $conn->prepare('SELECT * FROM users WHERE email = :email');
$stmt->execute([':email' => $email]);
$account = $stmt->fetch();

if (!$account || !password_verify($password, $account['password_hash']) || $account['is_active'] == 0) {
    terug_met_fout('E-mailadres of wachtwoord klopt niet.', 'inloggen.php');
}

session_regenerate_id(true);
$_SESSION['user_id'] = (int) $account['id'];
melding('success', 'Je bent ingelogd. Tijd om te koken!');
header('Location: profiel.php');
exit;
