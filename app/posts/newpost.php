<?php
declare(strict_types=1);

require_once __DIR__.'/../autoload.php';

if (!empty($_POST['link']) && !empty($_POST['title']))
{
    $link = filter_var($_POST['link'], FILTER_SANITIZE_URL);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

    if (!substr($link, 0, 7) === 'http://' || !substr($link, 0, 8) === 'https://')
    {
        $link = 'http://'.$link;
    }

    $addPost = $pdo->prepare("INSERT INTO posts
                            (link, title, time, user_id, description)
                            VALUES
                            (:link, :title, strftime('%s'), :user_id, :description)");
    if(!$addPost)
    {
        die(var_dump($pdo->errorInfo()));
    }
    $addPost->bindParam(':link', $link, PDO::PARAM_STR);
    $addPost->bindParam(':title', $title, PDO::PARAM_STR);
    $addPost->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $addPost->bindParam(':description', $description, PDO::PARAM_STR);
    $addPost->execute();

    $linkToPost = $pdo->prepare("SELECT post_id FROM posts WHERE user_id=:user_id ORDER BY time DESC LIMIT 1");
    $linkToPost->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $linkToPost->execute();
    $linkToPost = $linkToPost->fetch();

    redirect('/?page=post&post='.$linkToPost['post_id']);
}
else
{
    $_SESSION['forms']['invalidPost'] = true;
    redirect('/?page=newpost');
}
