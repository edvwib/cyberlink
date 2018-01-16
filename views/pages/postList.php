<?php
declare(strict_types=1);

require_once __DIR__.'/../header.php';

$posts = $pdo->query("SELECT * FROM posts");
$posts = $posts->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="posts">
    <?php if (isset($_SESSION['forms']['voteFailed']) && $_SESSION['forms']['voteFailed']): ?>
        <p id="voteFail" class="bg-warning">You need to be <a href="?page=login">logged in</a> in order to vote.</p>
        <?php $_SESSION['forms']['voteFailed'] = false; ?>
    <?php endif; ?>
<?php
foreach ($posts as $post) {
    $score = getPostScoreByID(intval($post['post_id']), $pdo);
    $user = getUserByID((int)$post['user_id'], $pdo);
    $commentCount = getCommentCountByID(intval($post['post_id']), $pdo);

    if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'])
    {
        $vote = getVoteAction($_SESSION['user_id'], (int) $post['post_id'], $pdo);
    }
    else
    {
        $vote = 0;
    }
    ?>

    <div class="post" id="<?php echo $post['post_id'] ?>">
        <div class="scoreContainer">
            <form class="scoreForm" action="/../../app/posts/postVote.php" method="post">
                <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                <input type="hidden" name="src" value="frontpage">
                <button class="u_vote btn <?php echo ($vote===1)?('active'):('') ?>" type="submit" name="upvote">▲</button>
                <span class="postScore"><?php echo ($score===1)?($score.'pt'):($score.'pts') ?></span>
                <button class="d_vote btn <?php echo ($vote===-1)?('active'):('') ?>" type="submit" name="downvote">▼</button>
            </form>
        </div>
        <div class="postDetailContainer">
            <h4 class="postTitle">
                <a class="postLink" href="<?php echo $post['link'] ?>"><?php echo $post['title']; ?></a>
            </h4>
            <span class="postTime"><?php echo date($dateFormat, (int)$post['time']); ?> by </span><a class="postUser" href="?page=user&user=<?php echo $user ?>">/u/<?php echo $user ?></a><br>
            <span class="postDescription"><?php echo ($post['description']!=null && strlen($post['description']) > 50)?(substr($post['description'], 0, 50). '...'):($post['description']) ?></span><br>
            <a class="postComments" href="?page=post&post=<?php echo $post['post_id'] ?>">comments(<?php echo $commentCount ?>)</a>
        </div>
    </div>
    <?php
}
?>
</div>
