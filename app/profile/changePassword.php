<?php
declare(strict_types=1);

require_once __DIR__.'/../autoload.php';

if (isset($_POST['old-password']) && isset($_POST['new-password']))
{
    $oldPass = $_POST['old-password'];
    $newPassHash = password_hash($_POST['new-password'], PASSWORD_DEFAULT);

    $checkOldPass = $pdo->prepare("SELECT password FROM users WHERE user_id=:user_id");
    $checkOldPass->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $checkOldPass->execute();
    $checkOldPass = $checkOldPass->fetch(PDO::FETCH_ASSOC);

    if (password_verify($oldPass, $checkOldPass['password'])) {
        $updatePass = $pdo->prepare("UPDATE users SET password=:newPass WHERE user_id=:user_id");
        $updatePass->bindParam(':newPass', $newPassHash, PDO::PARAM_STR);
        $updatePass->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $updatePass->execute();
        if (!$updatePass) {
            die(var_dump($pdo->errorInfo()));
        }
        $_SESSION['forms']['passwordUpdated'] = true;
    }
    else
    {
        $_SESSION['forms']['updatePassFailed'] = true;
    }
}
redirect('/?page=profile');
