<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    $checkUser = $pdo->prepare("SELECT * FROM users WHERE username=:username");
    $checkUser->bindParam(':username', $username, PDO::PARAM_STR);
    $checkUser->execute();
    $user = $checkUser->fetchAll(PDO::FETCH_ASSOC);

    if (empty($user)) {
        echo "Wrong username or password.";
    }else if (password_verify($password, $user[0]['password'])) {
        $_SESSION['authenticated'] = true;
        $_SESSION['user'] = $user[0];
        header('Location: /');
    }else {
        echo "Wrong username or password.";
    }
}
