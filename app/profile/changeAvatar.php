<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (isset($_FILES['avatar'])) {
    $avatar = $_FILES['avatar'];

    $allowed = array("image/jpeg", "image/jpg", "image/png", "image/gif");



    if ($avatar['size'] >= 10000000){
        echo 'The uploaded file exceeded the file size limit (10MB).';
    }if(!in_array($avatar['type'], $allowed)) {
        echo 'The uploaded file is not in a valid format.';
    }else{
        move_uploaded_file($avatar['tmp_name'], __DIR__.'/avatar.png');
        $avatar = base64_encode(file_get_contents(__DIR__.'/avatar.png'));

        $addAvatar = $pdo->prepare("UPDATE users SET avatar=:avatar WHERE user_id=:user_id");
        $addAvatar->bindParam(':avatar', $avatar, PDO::PARAM_STR);
        $addAvatar->bindParam(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);
        $addAvatar->execute();
        if (!$addAvatar) {
            die(var_dump($pdo->errorInfo()));
        }
        unlink(__DIR__.'/avatar.png');
        header('Location: /?page=profile');
    }
}