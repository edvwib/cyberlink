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

    $score = getPostScoreByID((int) $post['post_id'], $pdo);
    $user = getUserByID((int) $post['user_id'], $pdo);
    $commentCount = getCommentCountByID((int) $post['post_id'], $pdo);
}


?>

<?php if (isset($_SESSION['forms']['voteFailed']) && $_SESSION['forms']['voteFailed']): ?>
    <p class="col-4 offset-4 bg-warning text-white">You need to be logged in in order to vote.</p>
    <?php $_SESSION['forms']['voteFailed'] = false; ?>
<?php endif; ?>

<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2">
        <div class="row">
            <div class="col-1">
                <form action="/../../app/posts/postVote.php" method="post">
                    <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                    <button class="btn btn-link vote" type="submit" name="upvote">▲</button>
                    <span><?php echo ($score===1)?($score.'pt'):($score.'pts') ?></span>
                    <button class="btn btn-link vote" type="submit" name="downvote">▼</button>
                </form>
            </div>
            <a class="col-10 offset-1 verticalAlign" href="http://<?php echo $post['link'] ?>"><?php echo $post['title']; ?></a>
        </div>
        <div class="row">
            <span class="col-7 col-sm-5"><?php echo date($dateFormat, (int)$post['time']); ?></span>
        </div>
        <div class="row">
            <p class="col-12 mb-0"><?php echo ($post['description']!=null)?($post['description']):('No description to display') ?></p>
        </div>
        <div class="row">
            <a class="col-8" href="?page=user&user=<?php echo $user ?>">/u/<?php echo $user ?></a>
            <?php if (isset($_SESSION['user_id']) && isPostOwner((int) $post['post_id'], $_SESSION['user_id'], $pdo)): ?>
                <a class="col-1 offset-1" href="?page=post&post=<?php echo $post['post_id'] ?>&action=edit">edit</a>
                <a id="deletePost" class="col-2" href="?page=post&post=<?php echo $post['post_id'] ?>&action=delete">delete</a>
            <?php endif; ?>
        </div>
    </div>
    <hr>
</div>


<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 panel">
      <?php if ($_SESSION['authenticated']): ?>
          <form class="col-10 offset-1 topLevelCommentForm" action="/../../app/posts/topLevelComment.php" method="post">
              <h5 class="col-12">Add a comment:</h5>
              <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
              <textarea class="col-12 form-control" name="comment" placeholder="Discuss this post..." rows="4" cols="50" required></textarea>
              <?php if (isset($_SESSION['forms']['commentInvalid']) && $_SESSION['forms']['commentInvalid']): ?>
                  <p class="col-12 bg-danger text-white">Invalid comment.</p>
                  <?php $_SESSION['forms']['commentInvalid'] = false; ?>
              <?php endif; ?>
              <button class="col-12 btn" type="submit" name="submit">Comment</button>
          </form>
      <?php endif; ?>
    </div>
</div>

<div class="row">
  <h4 class="col-12 col-sm-8 offset-sm-2">Comments(<?php echo $commentCount ?>)</h4>
  <div class="col-12 col-sm-8 offset-sm-2">
    <?php foreach ($comments as $comment): ?>
        <?php $user = getUserByID((int) $comment['user_id'], $pdo); ?>
        <div class="row">
          <div class="col-12">
            <a class="" href="?page=user&user=<?php echo $user; ?>" class="commentAuthor">/u/<?php echo $user; ?></a>
            <span class=""><?php echo date($dateFormat, (int)$comment['time']); ?></span>
          </div>
        </div>
        <div class="row">
          <span class="col-12"><?php echo $comment['comment']; ?></span>
        </div>
        <div class="row">
          <a href="#" class="col-2 commentReply">reply</a>
        </div>
        <hr>
    <?php endforeach; ?>
  </div>
</div>
