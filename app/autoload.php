<?php
declare(strict_types=1);

// Start the session engines.
session_start();
if (isset($_SESSION['user'])) {
    $_SESSION['authenticated'] = true;
}else {
    $_SESSION['authenticated'] = false;
}

// Set the default timezone to Coordinated Universal Time.
date_default_timezone_set('UTC');

// Set the default character encoding to UTF-8.
mb_internal_encoding('UTF-8');

// Include the helper functions.
require __DIR__.'/functions.php';

// Fetch the global configuration array.
$config = require __DIR__.'/config.php';

// Setup the database connection.
$pdo = new PDO($config['database_path']);

//Set default dateFormat
$dateFormat = $config['dateFormat'];
