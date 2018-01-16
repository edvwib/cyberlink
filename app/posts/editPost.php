<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (!empty($_POST['link']) && !empty($_POST['title']))
{
    $link = filter_var($_POST['link'], FILTER_SANITIZE_URL);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

    if (substr($link, 0, 7) === 'http://' || substr($link, 0, 8) === 'https://')
    {
        echo 'has http://<br>';
    }
    else
    {
        $link = 'http://'.$link;
    }

    $editPost = $pdo->prepare("UPDATE posts
                            SET link=:link,
                                title=:title,
                                description=:description
                            WHERE post_id=:post_id AND user_id=:user_id");
    $editPost->bindParam(':link', $link, PDO::PARAM_STR);
    $editPost->bindParam(':title', $title, PDO::PARAM_STR);
    $editPost->bindParam(':description', $description, PDO::PARAM_STR);
    $editPost->bindParam(':post_id', $_POST['post_id'], PDO::PARAM_INT);
    $editPost->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $editPost->execute();
    if (!$editPost)
    {
        die(var_dump($pdo->errorInfo()));
    }
}
redirect("/?page=post&post=".$_POST['post_id']);
