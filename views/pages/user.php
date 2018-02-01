<?php
declare(strict_types=1);

require_once __DIR__.'/../header.php';

if (isset($_GET['user'])) {
    $username = filter_var($_GET['user'], FILTER_SANITIZE_STRING);

    $userID = $pdo->prepare("SELECT user_id FROM users WHERE username=:username");
    $userID->bindParam(':username', $username, PDO::PARAM_STR);
    $userID->execute();
    $userID = $userID->fetchAll(PDO::FETCH_ASSOC);
    if (empty($userID))
    {
        $_SESSION['forms']['userNotFound'] = true;
    }
    else
    {
        $userID = $userID[0]['user_id'];

        $userPosts = $pdo->prepare("SELECT * FROM posts WHERE user_id=:user_id");
        $userPosts->bindParam(':user_id', $userID, PDO::PARAM_INT);
        $userPosts->execute();
        $userPosts = $userPosts->fetchAll(PDO::FETCH_ASSOC);

        $user = getUserByID((int)$userID, $pdo);
    }
}

if (isset($_SESSION['forms']['userNotFound']) && $_SESSION['forms']['userNotFound'])
{
    ?>
    <div >
        <div >
            <p >There's no user with the username '<?php echo $username ?>'.</p>
        </div>
    </div>
    <?php
    $_SESSION['forms']['userNotFound'] = false;
}
else
{
    ?>
    <?php if (file_exists(__DIR__.'/../../assets/profiles/'.$userID.'.png')): ?>
        <img src="/../../assets/profiles/<?php echo $userID ?>.png" class="rounded mx-auto d-block" alt="avatar">
    <?php else: ?>
        <img src="/../../assets/profiles/0.png" class="rounded mx-auto d-block" alt="avatar">
    <?php endif; ?>
    <h2 class="text-center"><?php echo '/u/'.$username ?></h2>
    <?php
    foreach ($userPosts as $userPost)
    {
        $score = getPostScoreByID((int) $userPost['post_id'], $pdo);
        if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'])
        {
            $vote = getVoteAction($_SESSION['user_id'], (int) $userPost['post_id'], $pdo);
        }
        else
        {
            $vote = 0;
        }
        $commentCount = getCommentCountByID(intval($userPost['post_id']), $pdo);
        ?>
        <div class="post" id="<?php echo $userPost['post_id'] ?>">
            <div class="scoreContainer">
                <form class="scoreForm" action="/../../app/posts/postVote.php" method="post">
                    <input type="hidden" name="post_id" value="<?php echo $userPost['post_id']; ?>">
                    <input type="hidden" name="src" value="frontpage">
                    <button class="u_vote btn <?php echo ($vote===1)?('active'):('') ?>" type="submit" name="upvote">▲</button>
                    <span class="postScore"><?php echo ($score===1)?($score.'pt'):($score.'pts') ?></span>
                    <button class="d_vote btn <?php echo ($vote===-1)?('active'):('') ?>" type="submit" name="downvote">▼</button>
                </form>
            </div>
            <div class="postDetailContainer">
                <h4 class="postTitle">
                    <a class="postLink" href="<?php echo $userPost['link'] ?>"><?php echo $userPost['title']; ?></a>
                </h4>
                <span class="postTime" title="<?php echo date($dateFormat, (int)$userPost['time']) ?>"><?php echo getTimeAgo((int)$userPost['time']); ?> by </span><a class="postUser" href="?page=user&user=<?php echo $user ?>">/u/<?php echo $user ?></a><br>
                <span class="postDescription"><?php echo ($userPost['description']!=null && strlen($userPost['description']) > 50)?(substr($userPost['description'], 0, 50). '...'):($userPost['description']) ?></span><br>
                <a class="postComments" href="?page=post&post=<?php echo $userPost['post_id'] ?>">comments(<?php echo $commentCount ?>)</a>
            </div>
        </div>
        <?php
    }
}
