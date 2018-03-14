<?php
declare(strict_types=1);

require_once __DIR__.'/../autoload.php';

if (isset($_POST['new-email'])) {
    $newEmail = filter_var($_POST['new-email'], FILTER_SANITIZE_EMAIL);

    if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {//If email IS in a valid format
        if ($newEmail === getEmailByID($_SESSION['user_id'], $pdo)) { //If user is already using this email
            $_SESSION['forms']['changeEmailSame'] = true;
        } else {//Check if email is in use
            $checkNewEmail = $pdo->prepare("SELECT email FROM users WHERE email=:newEmail");
            $checkNewEmail->bindParam(':newEmail', $newEmail, PDO::PARAM_STR);
            $checkNewEmail->execute();
            $checkNewEmail = $checkNewEmail->fetchAll(PDO::FETCH_ASSOC);

            if (empty($checkNewEmail)) {//If email IS NOT active on another account
                $changeMail = $pdo->prepare("UPDATE users SET email=:newEmail WHERE user_id=:user_id");
                $changeMail->bindParam(':newEmail', $newEmail, PDO::PARAM_STR);
                $changeMail->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                $changeMail->execute();
                if (!$changeMail) {
                    die(var_dump($pdo->errorInfo()));
                }
                $_SESSION['forms']['emailUpdated'] = true;
            } else { //If email IS active on another account
                $_SESSION['forms']['changeEmailInUse'] = true;
            }
        }
    } else {//If email IS NOT in a valid format
        $_SESSION['forms']['changeEmailInvalid'] = true;
    }
}
redirect('/?page=profile');
