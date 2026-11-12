<?php
if ($user === null) {
    $_SESSION['melding'] = ['type' => 'error', 'message' => 'Log eerst in om verder te gaan.'];
    header('Location: inloggen.php');
    exit;
}
