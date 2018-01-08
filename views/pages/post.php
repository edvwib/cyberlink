<?php
declare(strict_types=1);

require_once __DIR__.'/../header.php';

if (isset($_GET['post'])) {
    $postID = filter_var($_GET['post'], FILTER_SANITIZE_NUMBER_INT);

    $post = $pdo->prepare("SELECT * FROM posts WHERE post_id=:post_id");
    if (!$post) {
        die(var_dump($pdo->errorInfo()));
    }
    $post->bindParam(':post_id', $postID, PDO::PARAM_INT);
    $post->execute();
    $post = $post->fetch(PDO::FETCH_ASSOC);

    $comments = $pdo->prepare("SELECT * FROM comments WHERE post_id=:post_id");
    if (!$comments) {
        die(var_dump($pdo->errorInfo()));
    }
    $comments->bindParam(':post_id', $postID, PDO::PARAM_INT);
    $comments->execute();
    $comments = $comments->fetchAll(PDO::FETCH_ASSOC);


    $up = $pdo->prepare("SELECT vote_type FROM user_votes WHERE post_id=:post_id AND vote_type=1 GROUP BY vote_type");
    $up->bindParam(':post_id', $post['post_id'], PDO::PARAM_INT);
    $up->execute();
    $up = $up->fetchAll(PDO::FETCH_ASSOC);
    $up = sizeof($up);

    $down = $pdo->prepare("SELECT vote_type FROM user_votes WHERE post_id=:post_id AND vote_type=0 GROUP BY vote_type");
    $down->bindParam(':post_id', $post['post_id'], PDO::PARAM_INT);
    $down->execute();
    $down = $down->fetchAll(PDO::FETCH_ASSOC);
    $down = sizeof($down);

    $score = $up-$down;
}


?>

<div class="row post">
    <div class="voteForm">
        <form action="/../../app/posts/postVote.php" method="post">
            <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
            <div>
            <button class="upvote" type="submit" name="upvote">▲</button>
            </div>
            <div>
            <button class="downvote" type="submit" name="downvote">▼</button>
            </div>
        </form>
    </div>
    <div class="score"><?php echo $score ?></div>
    <h2><a href="<?php echo $post['link'] ?>"><?php echo $post['title']; ?></a></h2>
    <a href="http://<?php echo parse_url($post['link'], PHP_URL_HOST); ?>">(<?php echo parse_url($post['link'], PHP_URL_HOST); ?>)</a>
</div>

<div class="row topLevelCommentFormDiv">
    <form class="topLevelCommentForm" action="/../../app/posts/topLevelComment.php" method="post">
        <div>
          <label for="comment">Add comment:</label><br>
          <textarea name="comment" rows="4" cols="50"></textarea>
        </div>
        <button type="submit" name="submit">Comment</button>
    </form>
</div>

<div class="row comments">
  <?php foreach ($comments as $comment): ?>
    <div class="commentContainer">
      <span class="commmentVote">
        <a href="" class="vote upvote">▲</a>
        <a href="" class="vote downvote">▼</a>
      </span>
      <div class="comment">
        <div class="commentData">
          <a href="#" class="commentAuthor">/u/<?php echo $comment['user_id']; ?></a>
          <?php echo $spacer ?>
          <p class="commentTime"><?php echo date($dateFormat, (int)$comment['time']); ?></p>
        </div>
          <p class="commentText"><?php echo $comment['comment']; ?></p>
        <div class="commentControls">
          <a href="#" class="commentReply">reply</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
