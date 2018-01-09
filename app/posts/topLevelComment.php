<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (isset($_POST['comment'])) {
    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);

    $addComment = $pdo->prepare("INSERT INTO comments (comment, time, user_id, parent_id, post_id)
                                VALUES (:comment, strftime('%s'), :user_id, null, :post_id)");
    $addComment->bindParam(':comment', $comment, PDO::PARAM_STR);
    $addComment->bindParam(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);
    $addComment->bindParam(':post_id', $_POST['post_id'], PDO::PARAM_INT);
    $addComment->execute();
    if (!$addComment) {
        die(var_dump($pdo->errorInfo()));
    }
}
header("Location: /?page=post&post=$_POST[post_id]");
