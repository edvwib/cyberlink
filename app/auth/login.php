<?php
declare(strict_types=1);

require_once __DIR__.'/../autoload.php';

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = strtolower(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
    $password = $_POST['password'];

    $checkUser = $pdo->prepare("SELECT user_id, lower(username) as username, password FROM users WHERE username=:username");
    $checkUser->bindParam(':username', $username, PDO::PARAM_STR);
    $checkUser->execute();
    $checkUser = $checkUser->fetchAll(PDO::FETCH_ASSOC);

    if (empty($checkUser)) {//If user doesn't exist
        $_SESSION['forms']['failedAuth'] = true;
        $_SESSION['formInput'] = [
            'username' => $username,
        ];
    } elseif (password_verify($password, $checkUser[0]['password'])) {//If password correct
        $_SESSION['authenticated'] = true;
        $_SESSION['user_id'] = (int) $checkUser[0]['user_id'];
        $_SESSION['forms']['failedAuth'] = false;

        unset($_SESSION['formInput']); //Remove so it doesn't get used elsewhere
        redirect('/');
    }
}
redirect('/?page=login');
