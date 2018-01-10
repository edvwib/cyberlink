<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if (isset($_GET['post']) && $_GET['action'] === 'delete') {
    $postID = intval($_GET['post']);
    $deletedLink = "?page=post&post=$postID";

    $checkComments = $pdo->prepare("SELECT post_id FROM comments WHERE post_id=:post_id");
    $checkComments->bindParam(':post_id', $postID, PDO::PARAM_INT);
    $checkComments = $checkComments->fetchAll(PDO::FETCH_ASSOC);
    if (empty($checkComments)) { //Deletes post entirely
        $deletePost = $pdo->prepare("DELETE FROM posts WHERE post_id=:post_id AND user_id=:user_id");
        $deletePost->bindParam(':post_id', $postID, PDO::PARAM_INT);
        $deletePost->bindParam(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);
        $deletePost->execute();
        if (!$deletePost) {
            die(var_dump($pdo->errorInfo()));
        }
        $deleteVotes = $pdo->prepare("DELETE FROM user_votes WHERE post_id=:post_id");
        $deleteVotes->bindParam(':post_id', $postID, PDO::PARAM_INT);
        $deleteVotes->execute();
        if (!$deleteVotes) {
            die(var_dump($pdo->errorInfo()));
        }
        redirect('/');
    }else { //Deletes post, keeps comments
        $deletePostdata = $pdo->prepare("UPDATE posts SET link=:deletedLink,
                                                      title='[deleted]',
                                                      description='[deleted]',
                                                      user_id=0
                                     WHERE post_id=:post_id
                                     AND   user_id=:user_id");
        $deletePostdata->bindParam(':deletedLink', $deletedLink, PDO::PARAM_STR);
        $deletePostdata->bindParam(':post_id', $postID, PDO::PARAM_INT);
        $deletePostdata->bindParam(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);
        $deletePostdata->execute();
        if (!$deletePostdata) {
            die(var_dump($pdo->errorInfo()));
        }
        redirect("/$deletedLink");
    }
}
