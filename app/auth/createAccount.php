<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (!empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $mail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $errors = 0;

    $checkMail = $pdo->prepare("SELECT email FROM users WHERE email=:mail");
    $checkMail->bindParam(':mail', $mail, PDO::PARAM_STR);
    $checkMail->execute();
    $result = $checkMail->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($result)) {
        echo "There's already a user registered with this email.";
        $errors++;
    }

    $checkUsername = $pdo->prepare("SELECT username FROM users WHERE username=:username");
    $checkUsername->bindParam(':username', $username, PDO::PARAM_STR);
    $checkUsername->execute();
    $result = $checkUsername->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($result)) {
        echo "This username is already taken.";
        $errors++;
    }

    if ($errors !== 0) {
        exit;
    }

    $createAccount = $pdo->prepare("INSERT INTO users
                                    (email, password, username) VALUES
                                    (:mail, :password, :username)");

    $createAccount->bindParam(':mail', $mail, PDO::PARAM_STR);
    $createAccount->bindParam(':password', $passwordHash, PDO::PARAM_STR);
    $createAccount->bindParam(':username', $username, PDO::PARAM_STR);
    $createAccount->execute();

    $_SESSION['authenticated'] = true;
    $_SESSION['user'] = $username;
}else {

}
