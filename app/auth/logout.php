<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

$_SESSION['authenticated'] = false;
unset($_SESSION['user']);

header('Location: /');
