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

/**
 * Fetches the score for a post and returns the result
 * @param  int $postID [The ID of a post]
 * @param  PDO $pdo    [DB connection]
 * @return int         [The score of a post]
 */
function getPostScoreByID(int $postID, PDO $pdo):int
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

/**
 * Fetches the vote type a user has on a post
 * @param  int $userID [The ID of a user]
 * @param  int $postID [The ID of a post]
 * @param  PDO $pdo    [DB connection]
 * @return int         [The vote type from the specified user (-1, 0 or 1)]
 */
function getVoteAction($userID, int $postID, PDO $pdo):int
{
    $userID = (int) $userID;
    $checkUserVote = $pdo->prepare("SELECT vote_type FROM user_votes WHERE post_id=:post_id AND user_id=:user_id");
    $checkUserVote->bindParam(':post_id', $postID, PDO::PARAM_INT);
    $checkUserVote->bindParam(':user_id', $userID, PDO::PARAM_INT);
    $checkUserVote->execute();
    $checkUserVote = $checkUserVote->fetch(PDO::FETCH_ASSOC);

    return (int) $checkUserVote['vote_type'];
}

/**
 * [Fetches the username connected to the given ID]
 * @param  [type] $userID [The ID of a user]
 * @param  PDO    $pdo    [DB connection]
 * @return string         [The username of the specified ID]
 */
function getUserByID($userID, PDO $pdo):string
{
    $userID = (int) $userID;
    $user = $pdo->prepare("SELECT username FROM users WHERE user_id=:user_id");
    $user->bindParam(':user_id', $userID, PDO::PARAM_INT);
    $user->execute();
    $user = $user->fetch(PDO::FETCH_ASSOC);

    return $user['username'];
}

/**
 * [Fetches the email connected to the given ID]
 * @param  [type] $userID [The ID of a user]
 * @param  PDO    $pdo    [DB connection]
 * @return string         [The email of the specified ID]
 */
function getEmailByID($userID, PDO $pdo):string
{
    $userID = (int) $userID;
    $email = $pdo->prepare("SELECT email FROM users WHERE user_id=:user_id");
    $email->bindParam(':user_id', $userID, PDO::PARAM_INT);
    $email->execute();
    $email = $email->fetch(PDO::FETCH_ASSOC);

    return $email['email'];
}

/**
 * [Fetches the amount of comments on a post]
 * @param  int $postID [The ID of the post]
 * @param  PDO $pdo    [DB connection]
 * @return int         [The ammount of comments on the given post]
 */
function getCommentCountByID(int $postID, PDO $pdo):int
{
    $commentCount = $pdo->prepare("SELECT COUNT() FROM comments WHERE post_id=:post_id");
    $commentCount->bindParam(':post_id', $postID, PDO::PARAM_INT);
    $commentCount->execute();
    $commentCount = $commentCount->fetch(PDO::FETCH_ASSOC);

    return (int) $commentCount['COUNT()'];
}

/**
 * [Checks if the user is the creator of a post]
 * @param  int  $postID [The ID of a user]
 * @param  int  $userID [The ID of a post]
 * @param  PDO  $pdo    [DB connection]
 * @return bool         []
 */
function isPostOwner(int $postID, $userID, PDO $pdo):bool
{
    $userID = (int) $userID;
    $post = $pdo->query("SELECT user_id FROM posts WHERE post_id=$postID");
    $post = $post->fetch(PDO::FETCH_ASSOC);

    return (int) $post['user_id'] === $userID;
}

/**
 * [Checks if the user is the creator of a post]
 * @param  int  $commentID [The ID of a comment]
 * @param  int  $userID [The ID of a user]
 * @param  PDO  $pdo    [DB connection]
 * @return bool         []
 */
function isCommentOwner(int $commentID, $userID, PDO $pdo):bool
{
    $userID = (int) $userID;
    $comment = $pdo->query("SELECT user_id FROM comments WHERE comment_id=$commentID");
    $comment = $comment->fetch(PDO::FETCH_ASSOC);

    return (int) $comment['user_id'] === $userID;
}

function getTimeAgo(int $timeThen): string
{
    $timeDiff = time() - $timeThen;
    if ($timeDiff < 60) { //Less than a minute
        return round($timeDiff) . ' seconds ago';
    }else if ($timeDiff < 3600) { //Less than one hour
        return round($timeDiff/60) . ' minutes ago';
    }elseif ($timeDiff < 86400) { //Less than 24 hours
        return round($timeDiff/3600) . ' hours ago';
    }elseif ($timeDiff < 31536000) { //Less than a year
        return round($timeDiff/86400) . ' days ago';
    }

    return "";
}
