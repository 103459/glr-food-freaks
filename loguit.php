<?php
require 'config.php';
check_csrf();

$_SESSION = [];
session_regenerate_id(true);
melding('success', 'Je bent uitgelogd.');
header('Location: index.php');
exit;
