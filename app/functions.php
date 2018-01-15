<?php
declare(strict_types=1);

if (!function_exists('redirect'))
{
    /**
     * Redirect the user to given path.
     *
     * @param string $path
     *
     * @return void
     */
    function redirect($path){
        header("Location: ${path}");
        exit;
    }
}

function getPostScoreByID($postID, PDO $pdo):int
{
    $up = $pdo->prepare("SELECT vote_type FROM user_votes WHERE post_id=:post_id AND vote_type=1");
    $up->bindParam(':post_id', $postID, PDO::PARAM_INT);
    $up->execute();
    $up = $up->fetchAll(PDO::FETCH_ASSOC);
    $up = sizeof($up);

    $down = $pdo->prepare("SELECT vote_type FROM user_votes WHERE post_id=:post_id AND vote_type=-1");
    $down->bindParam(':post_id', $postID, PDO::PARAM_INT);
    $down->execute();
    $down = $down->fetchAll(PDO::FETCH_ASSOC);
    $down = sizeof($down);

    return $up-$down;
}
function getUserByID($userID, PDO $pdo):string
{
    $user = $pdo->prepare("SELECT username FROM users WHERE user_id=:user_id");
    $user->bindParam(':user_id', $userID, PDO::PARAM_INT);
    $user->execute();
    $user = $user->fetch(PDO::FETCH_ASSOC);
    return $user['username'];
}
function getEmailByID($userID, PDO $pdo):string
{
    $email = $pdo->prepare("SELECT email FROM users WHERE user_id=:user_id");
    $email->bindParam(':user_id', $userID, PDO::PARAM_INT);
    $email->execute();
    $email = $email->fetch(PDO::FETCH_ASSOC);
    return $email['email'];
}

function getCommentCountByID($postID, PDO $pdo)
{
    $commentCount = $pdo->prepare("SELECT COUNT() FROM comments WHERE post_id=:post_id");
    $commentCount->bindParam(':post_id', $postID, PDO::PARAM_INT);
    $commentCount->execute();
    $commentCount = $commentCount->fetch(PDO::FETCH_ASSOC);

    return $commentCount['COUNT()'];
}


function isPostOwner($postID, $userID, PDO $pdo)
{
    $post = $pdo->query("SELECT user_id FROM posts WHERE post_id=$postID");
    $post = $post->fetch(PDO::FETCH_ASSOC);

    return $post['user_id'] == $userID;
}
function isCommentOwner($commentID, $userID)
{

}
