<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    $checkUser = $pdo->prepare("SELECT user_id, email, username, password FROM users WHERE username=:username");
    $checkUser->bindParam(':username', $username, PDO::PARAM_STR);
    $checkUser->execute();
    $user = $checkUser->fetchAll(PDO::FETCH_ASSOC);

    if (empty($user)) {
        $_SESSION['failedAuth'] = true;
        redirect('/?page=login');
    }else if (password_verify($password, $user[0]['password'])) {
        $_SESSION['authenticated'] = true;
        $_SESSION['user'] = $user[0];
        $_SESSION['failedAuth'] = false;
        redirect('/');
    }else {
        $_SESSION['failedAuth'] = true;
        redirect('/?page=login');
    }
}
