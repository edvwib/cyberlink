<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (!empty($_POST['username']) && !empty($_POST['password']))
{
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    $checkUser = $pdo->prepare("SELECT user_id, email, username, password FROM users WHERE username=:username");
    $checkUser->bindParam(':username', $username, PDO::PARAM_STR);
    $checkUser->execute();
    $checkUser = $checkUser->fetchAll(PDO::FETCH_ASSOC);

    if (empty($checkUser))
    {//If user doesn't exist
        $_SESSION['forms']['failedAuth'] = true;
    }else if (password_verify($password, $checkUser[0]['password']))
    {//If password correct
        $_SESSION['authenticated'] = true;
        $_SESSION['user'] = $checkUser[0];
        $_SESSION['failedAuth'] = false;
        redirect('/');
    }else
    {//If password incorrect
        $_SESSION['forms']['failedAuth'] = true;
    }
}
redirect('/?page=login');
