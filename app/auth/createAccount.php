<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (!empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password']))
{
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {//If email is not correct format
        $_SESSION['forms']['emailInvalid'] = true;
    }
    else
    {//Check if email is not in use
        $checkMail = $pdo->prepare("SELECT email FROM users WHERE email=:email");
        $checkMail->bindParam(':email', $email, PDO::PARAM_STR);
        $checkMail->execute();
        $checkMail = $checkMail->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($checkMail))
        {
            $_SESSION['forms']['emailInUse'] = true;
        }
        else
        {//Check if username is not in use
            $checkUsername = $pdo->prepare("SELECT username FROM users WHERE username=:username");
            $checkUsername->bindParam(':username', $username, PDO::PARAM_STR);
            $checkUsername->execute();
            $checkUsername = $checkUsername->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($checkUsername))
            {
                $_SESSION['forms']['usernameInUse'] = true;
            }
        }
    }
    if (!$_SESSION['forms']['emailInUse'] && !$_SESSION['forms']['usernameInUse'])
    {//If both email and username are not in use
        $createAccount = $pdo->prepare("INSERT INTO users
                                        (email, password, username) VALUES
                                        (:mail, :password, :username)");

        $createAccount->bindParam(':mail', $mail, PDO::PARAM_STR);
        $createAccount->bindParam(':password', $passwordHash, PDO::PARAM_STR);
        $createAccount->bindParam(':username', $username, PDO::PARAM_STR);
        $createAccount->execute();
    }
}
redirect('/?page=login');
