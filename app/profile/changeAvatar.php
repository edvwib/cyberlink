<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (isset($_FILES['avatar']))
{
    $avatar = $_FILES['avatar'];
    $allowedFormats = array("image/jpeg", "image/jpg", "image/png", "image/gif");

    if ($avatar['size'] >= 10000000)
    {//If file is too big
        $_SESSION['forms']['avatarSizeLimit'] = true;
    }
    else if(!in_array($avatar['type'], $allowedFormats))
    {//If file is not in an allowed format
        $_SESSION['forms']['avatarInvalidType'] = true;
    }
    else
    {//If file is accepted
        //Give the file a unique name in case two avatars are changed at the same time
        move_uploaded_file($avatar['tmp_name'], __DIR__.'/avatar'. $_SESSION['user']['user_id'] .'.png');
        $avatar = base64_encode(file_get_contents(__DIR__.'/avatar'. $_SESSION['user']['user_id'] .'.png'));

        $addAvatar = $pdo->prepare("UPDATE users SET avatar=:avatar WHERE user_id=:user_id");
        $addAvatar->bindParam(':avatar', $avatar, PDO::PARAM_STR);
        $addAvatar->bindParam(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);
        $addAvatar->execute();
        if (!$addAvatar)
        {
            die(var_dump($pdo->errorInfo()));
        }
        unlink(__DIR__.'/avatar'. $_SESSION['user']['user_id'] .'.png');
        $_SESSION['forms']['avatarUpdated'] = true;
    }
}
redirect('/?page=profile');
