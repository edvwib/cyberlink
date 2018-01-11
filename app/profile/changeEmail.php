<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (isset($_POST['new-email'])) {
    $newMail = filter_var($_POST['new-email'], FILTER_SANITIZE_EMAIL);

    if (filter_var($newMail, FILTER_VALIDATE_EMAIL)) {
        echo 'valid';
        $changeMail = $pdo->prepare("UPDATE users SET email=:newMail WHERE user_id=:user_id");
        $changeMail->bindParam(':newMail', $newMail, PDO::PARAM_STR);
        $changeMail->bindParam(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);
        $changeMail->execute();
        if (!$changeMail) {
            die(var_dump($pdo->errorInfo()));
        }
        $_SESSION['user']['email'] = $newMail;
        $_SESSION['forms']['emailUpdated'] = true;
    }else {
        $_SESSION['forms']['changeEmailInvalid'] = true;
    }
}
redirect('/?page=profile');
