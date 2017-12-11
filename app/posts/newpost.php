<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (!empty($_POST['link']) && !empty($_POST['title'])) {
    $link = filter_var($_POST['link'], FILTER_SANITIZE_URL);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);

    $addPost = $pdo->prepare("INSERT INTO posts
                            (link, title, time, votes, user_id)
                            VALUES
                            (:link, :title, date('now'), 0, :user_id)");
    if(!$addPost){
        var_dump($addPost);
        exit;
    }
    $addPost->bindParam(':link', $link, PDO::PARAM_STR);
    $addPost->bindParam(':title', $title, PDO::PARAM_STR);
    $addPost->bindParam(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);
    $addPost->execute();

    header('Location: /');
}
