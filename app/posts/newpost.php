<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (!empty($_POST['link']) && !empty($_POST['title'])) {
    $link = filter_var($_POST['link'], FILTER_SANITIZE_URL);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

    if(!filter_var($link, FILTER_VALIDATE_URL)){
        $link = 'http://'.$link;
        if (!filter_var($link, FILTER_VALIDATE_URL)) {
            echo 'Not a valid link';
        }
    }

    $addPost = $pdo->prepare("INSERT INTO posts
                            (link, title, time, user_id, description)
                            VALUES
                            (:link, :title, date('now'), :user_id, :description)");
    if(!$addPost){
        die(var_dump($pdo->errorInfo()));
    }
    $addPost->bindParam(':link', $link, PDO::PARAM_STR);
    $addPost->bindParam(':title', $title, PDO::PARAM_STR);
    $addPost->bindParam(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);
    $addPost->bindParam(':description', $description, PDO::PARAM_STR);
    $addPost->execute();

    redirect('/');
}
