<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (isset($_POST['bio'])) {
    $newBio = filter_var($_POST['bio'], FILTER_SANITIZE_STRING);

    $changeBio = $pdo->prepare("UPDATE users SET bio=:newBio WHERE user_id=:user_id");
    $changeBio->bindParam(':newBio', $newBio, PDO::PARAM_STR);
    $changeBio->bindParam(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);
    $changeBio->execute();
    if (!$changeBio) {
        die(var_dump($pdo->errorInfo()));
    }
    $_SESSION['forms']['bioUpdated'] = true;
}
header('Location: /?page=profile');
