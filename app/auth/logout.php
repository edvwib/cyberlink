<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

unset($_SESSION['authenticated']);

header('Location: /');
