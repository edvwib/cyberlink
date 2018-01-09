<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (isset($_POST['new-username'])) {
    $newUsername = filter_var($_POST['new-username'], FILTER_SANITIZE_STRING);

    $changeUsername = $pdo->prepare("UPDATE users SET username=:newUsername WHERE user_id=:user_id");
    $changeUsername->bindParam(':newUsername', $newUsername, PDO::PARAM_STR);
    $changeUsername->bindParam(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);
    $changeUsername->execute();
    if (!$changeUsername) {
        die(var_dump($pdo->errorInfo()));
    }
    $_SESSION['user']['username'] = $newUsername;
    $_SESSION['forms']['usernameUpdated'] = true;
}
redirect('/?page=profile')
