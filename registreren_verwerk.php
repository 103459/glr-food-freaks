<?php
require 'config.php';
check_csrf();

$username = trim((string) ($_POST['username'] ?? ''));
$email = strtolower(trim((string) ($_POST['email'] ?? '')));
$password = (string) ($_POST['password'] ?? '');

$stmt = $conn->prepare('SELECT id FROM users WHERE username = :username OR email = :email');
$stmt->execute([':username' => $username, ':email' => $email]);
$alreadyUsed = $stmt->fetch();

$error = '';
if (!preg_match('/^[A-Za-z0-9_.-]{3,40}$/', $username)) {
    $error = 'Gebruikersnaam: gebruik 3 tot 40 letters, cijfers, punten of streepjes, zonder spaties.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'E-mailadres: vul een geldig e-mailadres in, bijvoorbeeld naam@voorbeeld.nl.';
} elseif (strlen($password) < 8) {
    $error = 'Wachtwoord: gebruik minimaal 8 tekens.';
} elseif ($alreadyUsed) {
    $error = 'Deze gebruikersnaam of dit e-mailadres is al in gebruik.';
}
if ($error !== '') {
    terug_met_fout($error, 'registreren.php');
}

$stmt = $conn->prepare('INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :hash)');
$stmt->execute([':username' => $username, ':email' => $email, ':hash' => password_hash($password, PASSWORD_DEFAULT)]);

session_regenerate_id(true);
$_SESSION['user_id'] = (int) $conn->lastInsertId();
melding('success', 'Welkom bij GLR Food Freaks!');
header('Location: profiel.php');
exit;
