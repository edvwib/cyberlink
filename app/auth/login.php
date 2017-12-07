<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $checkUser = $pdo->prepare("SELECT username, password FROM users WHERE username=:username");
    $checkUser->bindParam(':username', $username, PDO::PARAM_STR);
    $checkUser->execute();
    $result = $checkUser->fetchAll(PDO::FETCH_ASSOC);

    if (empty($result)) {
        echo "Wrong username or password.";
    }else if (password_verify($password, $result[0]['password'])) {
        $_SESSION['authenticated'] = true;
        header('Location: /index.php');
    }else {
        echo "Wrong username or password.";
    }
}
