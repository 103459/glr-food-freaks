<?php
require 'config.php';
check_csrf();
require 'session.inc.php';

if ($user['role'] !== 'admin') {
    http_response_code(403);
    exit('Je hebt geen toegang tot dit onderdeel.');
}

$ID = (int) ($_POST['ID'] ?? 0);
if ($ID === (int) $user['id']) {
    terug_met_fout('Je kunt je eigen account niet uitschakelen.', 'beheer.php');
}

$stmt = $conn->prepare('UPDATE users SET is_active = 1 - is_active WHERE id = :id');
$stmt->execute([':id' => $ID]);

melding('success', 'Gebruikersstatus bijgewerkt.');
header('Location: beheer.php');
exit;
