<?php
declare(strict_types=1);

require_once __DIR__.'/views/header.php';

$statement = $pdo->query('SELECT * FROM comments');
$comments = $statement->fetchAll();

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_URL);

?>
  <?php if ($page === 'frontpage'): ?>
    <div class="comments">
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
  <?php else: ?>
    <div class="loginContainer">
      <ul>
        <li>Login</li>
        <li>Register</li>
      </ul>
    </div>
  <?php endif; ?>



<?php require __DIR__.'/views/footer.php'; ?>
