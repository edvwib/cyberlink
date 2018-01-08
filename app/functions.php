<?php
declare(strict_types=1);

if (!function_exists('redirect')) {
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

function getPostScore($postID, $pdo){
    $up = $pdo->prepare("SELECT vote_type FROM user_votes WHERE post_id=:post_id AND vote_type=1 GROUP BY vote_type");
    $up->bindParam(':post_id', $postID, PDO::PARAM_INT);
    $up->execute();
    $up = $up->fetchAll(PDO::FETCH_ASSOC);
    $up = sizeof($up);

    $down = $pdo->prepare("SELECT vote_type FROM user_votes WHERE post_id=:post_id AND vote_type=0 GROUP BY vote_type");
    $down->bindParam(':post_id', $postID, PDO::PARAM_INT);
    $down->execute();
    $down = $down->fetchAll(PDO::FETCH_ASSOC);
    $down = sizeof($down);

    return $up-$down;
}
function getUser($userID, $pdo){
    $user = $pdo->prepare("SELECT username FROM users WHERE user_id=:user_id");
    $user->bindParam(':user_id', $userID, PDO::PARAM_INT);
    $user->execute();
    $user = $user->fetchAll(PDO::FETCH_ASSOC);
    return $user[0]['username'];
}
