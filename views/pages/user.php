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
    }
}

if (isset($_SESSION['forms']['userNotFound']) && $_SESSION['forms']['userNotFound'])
{
    ?>
    <div class="row">
        <div class="col-12">
            <p class="bg-warning">There's no user with the username '<?php echo $username ?>'.</p>
        </div>
    </div>
    <?php
    $_SESSION['forms']['userNotFound'] = false;
}
else
{
    foreach ($userPosts as $userPost)
    {
        $score = getPostScoreByID((int) $userPost['post_id'], $pdo);
        $commentCount = getCommentCountByID(intval($userPost['post_id']), $pdo);
        ?>
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3">
                <div class="row">
                    <span class="col-1"><?php echo ($score===1)?($score.'pt'):($score.'pts') ?></span>
                    <a class="col-10 offset-1" href="<?php echo $userPost['link'] ?>"><?php echo $userPost['title']; ?></a>
                </div>
                <div class="row">
                    <span class="col-7 col-sm-5"><?php echo date($dateFormat, (int)$userPost['time']); ?></span>
                </div>
                <div class="row">
                    <p class="col-12 mb-0"><?php echo ($userPost['description']!=null && strlen($userPost['description']) > 100)?(substr($userPost['description'], 0, 100). '...'):($userPost['description']) ?></p>
                </div>
                <div class="row">
                    <a href="?page=user&user=<?php echo $username ?>" class="col-12">/u/<?php echo $username ?></a>
                </div>
                <div class="row">
                    <a href="?page=post&post=<?php echo $userPost['post_id'] ?>"class="col-12">comments(<?php echo $commentCount ?>)</a>
                </div>
            </div>
            <hr>
        </div>
        <?php
    }
}
