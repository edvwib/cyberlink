<?php
declare(strict_types=1);

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

    $score = getPostScoreByID($post['post_id'], $pdo);
    $user = getUserByID($post['user_id'], $pdo);
}


?>

<div class="row post">
    <div class="col-1 offset-1">
        <form action="/../../app/posts/postVote.php" method="post">
            <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
            <div>
            <button class="btn btn-link" type="submit" name="upvote">▲</button>
            </div>
            <div class="btn score"><?php echo ($score===1)?($score.'pt'):($score.'pts') ?></div>
            <div>
            <button class="btn btn-link" type="submit" name="downvote">▼</button>
            </div>
        </form>
    </div>

    <div class="col-9 postSingle">
        <a class="col-11 h3" href="<?php echo $post['link'] ?>"><?php echo $post['title']; ?></a>
        <a class="h6" href="http://<?php echo parse_url($post['link'], PHP_URL_HOST); ?>">(<?php echo parse_url($post['link'], PHP_URL_HOST); ?>)</a>
        <blockquote class="col-12 mb-0 blockquote">
            <p class="mb-0"><?php echo ($post['description']!=null)?($post['description']):('No description to display') ?></p>
        </blockquote>
        <a class="col-2" href="?page=user&user=<?php echo $user ?>">/u/<?php echo $user ?></a>
    </div>
</div>

<div class="row topLevelCommentFormDiv">
    <form class="col-6 offset-1 topLevelCommentForm" action="/../../app/posts/topLevelComment.php" method="post">
        <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
        <div>
          <label for="comment">Add comment:</label><br>
          <textarea name="comment" rows="4" cols="50" required></textarea>
        </div>
        <button class="col-2 btn" type="submit" name="submit">Comment</button>
    </form>
</div>

<div class="row comments">
  <?php foreach ($comments as $comment): ?>
    <div class="col-6 offset-1 commentContainer">
      <span class="commmentVote">
        <a href="" class="vote upvote">▲</a>
        <a href="" class="vote downvote">▼</a>
      </span>
      <div class="comment">
        <div class="commentData">
          <a href="?page=user&user=<?php echo getUserByID($comment['user_id'], $pdo); ?>" class="commentAuthor">/u/<?php echo getUserByID($comment['user_id'], $pdo); ?></a>
          <?php echo $spacer ?>
          <span class="commentTime"><?php echo date($dateFormat, (int)$comment['time']); ?></span>
        </div>
          <p class="commentText"><?php echo $comment['comment']; ?></p>
        <div class="commentControls">
          <a href="#" class="commentReply">reply</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
