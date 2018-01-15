<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (!empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password']))
{
    $email = strtolower(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $username = strtolower(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
    $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {//If email is not correct format
        $_SESSION['forms']['emailInvalid'] = true;
        redirect('/?page=login&fail');
    }

    $checkMail = $pdo->prepare("SELECT LOWER(email) AS email FROM users WHERE email=:email");
    $checkMail->bindParam(':email', $email, PDO::PARAM_STR);
    $checkMail->execute();
    $checkMail = $checkMail->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($checkMail))
    {
        $_SESSION['forms']['emailInUse'] = true;
    }

    $checkUsername = $pdo->prepare("SELECT lower(username) as username FROM users WHERE username=:username");
    $checkUsername->bindParam(':username', $username, PDO::PARAM_STR);
    $checkUsername->execute();
    $checkUsername = $checkUsername->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($checkUsername) || $username === '[deleted]')
    {
        $_SESSION['forms']['usernameInUse'] = true;
    }

    if (empty($checkMail) && empty($checkUsername))
    {//If both email and username are not in use
        $createAccount = $pdo->prepare("INSERT INTO users
            (email, username, password) VALUES
            (:mail, :username, :password)");

        $createAccount->bindParam(':mail', $email, PDO::PARAM_STR);
        $createAccount->bindParam(':username', $username, PDO::PARAM_STR);
        $createAccount->bindParam(':password', $passwordHash, PDO::PARAM_STR);
        $createAccount->execute();
        if (!$createAccount) {
            die(var_dump($pdo->errorInfo()));
        }
        $_SESSION['forms']['accountCreated'] = true;
        redirect('/?page=login');
    }
}
redirect('/?page=login&fail');
