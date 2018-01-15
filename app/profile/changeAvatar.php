<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (isset($_FILES['avatar']))
{
    $avatar = $_FILES['avatar'];
    $allowedFormats = array("image/png", "image/jpg", "image/jpeg");

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
        $fileName = $_SESSION['user_id'] . '.png';
        move_uploaded_file($avatar['tmp_name'], __DIR__.'/../../assets/profiles/'.$fileName);

        $_SESSION['forms']['avatarUpdated'] = true;
    }
}
redirect('/?page=profile');
