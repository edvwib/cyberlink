<?php
declare(strict_types=1);

require_once __DIR__.'/../autoload.php';

if (isset($_POST['old-password']) && isset($_POST['new-password1']) && isset($_POST['new-password2'])) {
    $oldPass = $_POST['old-password'];
    
    $checkOldPass = $pdo->prepare("SELECT password FROM users WHERE user_id=:user_id");
    $checkOldPass->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $checkOldPass->execute();
    $checkOldPass = $checkOldPass->fetch(PDO::FETCH_ASSOC);

    if ($_POST['new-password1'] !== $_POST['new-password2']) {
        $_SESSION['forms']['updatePassNotSame'] = true;
    }
    if (password_verify($oldPass, $checkOldPass['password'])) {
        $newPassHash = password_hash($_POST['new-password1'], PASSWORD_DEFAULT);

        $updatePass = $pdo->prepare("UPDATE users SET password=:newPass WHERE user_id=:user_id");
        $updatePass->bindParam(':newPass', $newPassHash, PDO::PARAM_STR);
        $updatePass->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $updatePass->execute();
        if (!$updatePass) {
            die(var_dump($pdo->errorInfo()));
        }
        $_SESSION['forms']['passwordUpdated'] = true;
    } else {
        $_SESSION['forms']['updatePassFailed'] = true;
    }
}
redirect('/?page=profile');
