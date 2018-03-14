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

    $score = getPostScoreByID((int) $post['post_id'], $pdo);
    $user = getUserByID((int) $post['user_id'], $pdo);
    $commentCount = getCommentCountByID((int) $post['post_id'], $pdo);

    if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
        $vote = getVoteAction($_SESSION['user_id'], (int) $post['post_id'], $pdo);
    }
}


?>

<?php if (isset($_SESSION['forms']['voteFailed']) && $_SESSION['forms']['voteFailed']): ?>
    <p class="col-12 col-md-4 offset-md-4 bg-warning text-white">You need to be <a href="?page=login">logged in</a> in order to vote.</p>
    <?php $_SESSION['forms']['voteFailed'] = false; ?>
<?php endif; ?>

<div class="post" id="<?php echo $post['post_id'] ?>">
    <div class="scoreContainer">
        <form class="scoreForm" action="/../../app/posts/postVote.php" method="post">
            <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
            <input type="hidden" name="src" value="post">
            <button class="u_vote btn <?php echo ($vote===1)?('active'):('') ?>" type="submit" name="upvote">▲</button>
            <span class="postScore"><?php echo ($score===1)?($score.'pt'):($score.'pts') ?></span>
            <button class="d_vote btn <?php echo ($vote===-1)?('active'):('') ?>" type="submit" name="downvote">▼</button>
        </form>
    </div>
    <div class="postDetailContainer">
        <h4 class="postTitle">
            <a class="postLink" href="<?php echo $post['link'] ?>"><?php echo $post['title']; ?></a>
        </h4>
        <span class="postTime" title="<?php echo date($dateFormat, (int)$post['time']) ?>"><?php echo getTimeAgo((int)$post['time']); ?> by </span><a class="postUser" href="?page=user&user=<?php echo $user ?>">/u/<?php echo $user ?></a><br>
        <span class="postDescription"><?php echo ($post['description']!=null && strlen($post['description']) > 50)?(substr($post['description'], 0, 50). '...'):($post['description']) ?></span><br>
        <?php if (isset($_SESSION['user_id']) && isPostOwner((int) $post['post_id'], $_SESSION['user_id'], $pdo)): ?>
            <a  href="?page=post&post=<?php echo $post['post_id'] ?>&action=edit">edit</a>
            <a id="deletePost"  href="?page=post&post=<?php echo $post['post_id'] ?>&action=delete">delete</a>
        <?php endif; ?>
    </div>
</div>


<div class="commentFormContainer">
    <?php if ($_SESSION['authenticated']): ?>
        <div class="col-12 col-sm-6 offset-sm-3 panel">
            <form class="col-12 topLevelCommentForm" action="/../../app/posts/topLevelComment.php" method="post">
                <h5 class="col-12">Add a comment:</h5>
                <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                <textarea class="col-12 form-control" name="comment" placeholder="Discuss this post..." rows="4" cols="50" required></textarea>
                <?php if (isset($_SESSION['forms']['commentInvalid']) && $_SESSION['forms']['commentInvalid']): ?>
                    <p class="col-12 bg-danger text-white">Invalid comment.</p>
                    <?php $_SESSION['forms']['commentInvalid'] = false; ?>
                <?php endif; ?>
                <button class="col-12 btn" type="submit" name="submit">Comment</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<div class="comments">
    <h4 class="commentsHeader">Comments(<?php echo $commentCount ?>)</h4>
    <?php foreach ($comments as $comment): ?>
        <?php $user = getUserByID((int) $comment['user_id'], $pdo); ?>
        <div class="comment">
            <div class="commentInfo">
                <a class="commentUser" href="?page=user&user=<?php echo $user; ?>" class="commentUser">/u/<?php echo $user ?></a>
                <span class="commentTime" title="<?php echo date($dateFormat, (int)$comment['time']) ?>"><?php echo getTimeAgo((int)$comment['time']); ?></span>
            </div>
            <p class="commentText">
              <?php echo $comment['comment']; ?>
            </p>
            <div class="commentActions">
                <a class="commentReply" href="#">reply</a>
                <?php if (isset($_SESSION['user_id']) && isCommentOwner((int) $comment['comment_id'], $_SESSION['user_id'], $pdo)): ?>
                    <!-- <a id="editComment"  href="">edit</a> -->
                    <!-- <a id="deleteComment"  href="">delete</a> -->
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
