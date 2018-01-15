<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if(isset($_POST['upvote']))
{
    $vote = 1;
}
if(isset($_POST['downvote']))
{
    $vote = -1;
}
if(!$_SESSION['authenticated'])
{
    unset($vote);
    $_SESSION['forms']['voteFailed'] = true;
}

if(isset($vote))
{
    $checkUserVote = $pdo->prepare("SELECT vote_type FROM user_votes WHERE post_id=:post_id AND user_id=:user_id");
    $checkUserVote->bindParam(':post_id', $_POST['post_id'], PDO::PARAM_INT);
    $checkUserVote->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $checkUserVote->execute();
    $checkUserVote = $checkUserVote->fetch(PDO::FETCH_ASSOC);

    if (empty($checkUserVote))
    { //If never voted on post
        $addVote = $pdo->prepare("INSERT INTO user_votes
                            (user_id, post_id, vote_type)
                            VALUES
                            (:user_id, :post_id, :vote)");
        $addVote->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $addVote->bindParam(':post_id', $_POST['post_id'], PDO::PARAM_INT);
        $addVote->bindParam(':vote', $vote, PDO::PARAM_INT);
        $addVote->execute();
    }else if ((int) $checkUserVote['vote_type'] === $vote)
    { //If has voted same on post
        $vote = 0;
        $removeVote = $pdo->prepare("UPDATE user_votes SET
                            (vote_type) = (:vote)
                            WHERE user_id=:user_id AND post_id=:post_id");
        $removeVote->bindParam(':vote', $vote, PDO::PARAM_INT);
        $removeVote->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $removeVote->bindParam(':post_id', $_POST['post_id'], PDO::PARAM_INT);
        $removeVote->execute();
    }else
    { //If has changed vote
        $updateVote = $pdo->prepare("UPDATE user_votes SET
                            (vote_type) = (:vote)
                            WHERE user_id=:user_id AND post_id=:post_id");
        $updateVote->bindParam(':vote', $vote, PDO::PARAM_INT);
        $updateVote->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $updateVote->bindParam(':post_id', $_POST['post_id'], PDO::PARAM_INT);
        $updateVote->execute();
    }
}
redirect("/?page=post&post=$_POST[post_id]");
