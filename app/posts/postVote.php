<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

if(isset($_POST['upvote'])){
    $vote = 1;
}
else if(isset($_POST['downvote'])){
    $vote = 0;
}else if(!$_SESSION['authenticated']){
    unset($vote);
}

if(isset($vote)){
    $voted = -1;

    $votes = $pdo->query("SELECT * FROM user_votes");
    $votes = $votes->fetchAll(PDO::FETCH_ASSOC);

    foreach ($votes as $row) {
        var_dump($row);
        if($row['post_id'] == $_POST['post_id'] && $row['user_id'] == $_SESSION['user']['user_id']){
            //If post is already voted on by user
            $voted = $row['vote_type'];
        }
    }

    $newVote = false;
    if($voted === -1){ //If new vote
        $newVote = true;
    }

    if($newVote){
        $addVote = $pdo->prepare("INSERT INTO user_votes
                            (user_id, post_id, vote_type)
                            VALUES
                            (:user_id, :post_id, :vote)");
        $addVote->bindParam(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);
        $addVote->bindParam(':post_id', $_POST['post_id'], PDO::PARAM_INT);
        $addVote->bindParam(':vote', $vote, PDO::PARAM_INT);
        $addVote->execute();
    }else{
        $updateVote = $pdo->prepare("UPDATE user_votes SET
                            (vote_type) = (:vote)
                            WHERE user_id=:user_id AND post_id=:post_id");
        $updateVote->bindParam(':vote', $vote, PDO::PARAM_INT);
        $updateVote->bindParam(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);
        $updateVote->bindParam(':post_id', $_POST['post_id'], PDO::PARAM_INT);
        $updateVote->execute();
    }

    header("Location: /?page=post&post=$_POST[post_id]");
}
