<?php
declare(strict_types=1);

//Always load setup
require __DIR__.'/../app/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $config['title'] ?></title>

    <link rel="stylesheet" href="/../assets/css/normalize.css">
    <link rel="stylesheet" href="/../assets/css/main.css">

</head>
<body>
    <?php require __DIR__.'/navigation.php'; ?>
    <div class="container">
