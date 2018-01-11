<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (isset($_POST['new-username']))
{
    $newUsername = filter_var($_POST['new-username'], FILTER_SANITIZE_STRING);

    if ($newUsername === $_SESSION['user']['username'])
    { //If user is already using this username
        $_SESSION['forms']['changeUsernameSame'] = true;
    }
    else
    {
        $checkNewUsername = $pdo->prepare("SELECT username FROM users WHERE username=:newUsername");
        $checkNewUsername->bindParam(':newUsername', $newUsername, PDO::PARAM_STR);
        $checkNewUsername->execute();
        $checkNewUsername = $checkNewUsername->fetchAll(PDO::FETCH_ASSOC);

        if (empty($checkNewUsername))
        {//If username is available
            $changeUsername = $pdo->prepare("UPDATE users SET username=:newUsername WHERE user_id=:user_id");
            $changeUsername->bindParam(':newUsername', $newUsername, PDO::PARAM_STR);
            $changeUsername->bindParam(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);
            $changeUsername->execute();
            if (!$changeUsername)
            {
                die(var_dump($pdo->errorInfo()));
            }
            $_SESSION['user']['username'] = $newUsername;
            $_SESSION['forms']['usernameUpdated'] = true;
        }
        else
        {//If another user is already using this username
            $_SESSION['forms']['changeUsernameInvalid'] = true;
        }
    }
}
redirect('/?page=profile');
