<?php
declare(strict_types=1);

require_once __DIR__.'/../autoload.php';

$_SESSION['authenticated'] = false;
unset($_SESSION['user_id']);

redirect('/');
