<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (!empty($_POST['comment'])) {
    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);

    $addComment = $pdo->prepare("INSERT INTO comments (comment, time, user_id, parent_id, votes, post_id)
                                VALUES (:comment, date('now'), :user_id, null, 1, :post_id)");
    if (!$addComment) {
        die(var_dump($pdo->errorInfo()));
    }
    exit;
    $addComment->bindParam(':comment', $comment, PDO::PARAM_STR);
    $addComment->bindParam(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);
    $addComment->bindParam(':post_id', $comment, PDO::PARAM_INT);


}
