<?php
declare(strict_types=1);

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
        $score = getPostScoreByID($userPost['post_id'], $pdo);
        $commentCount = getCommentCountByID(intval($userPost['post_id']), $pdo);
        ?>
        <div class="row">
          <div class="col-12">
            <div class="row">
              <span class="col-1"><?php echo ($score===1)?($score.'pt'):($score.'pts') ?></span>
              <a class="col-10 offset-1" href="http://<?php echo $userPost['link'] ?>"><?php echo $userPost['title']; ?></a>
            </div>
            <div class="row">
              <span class="col-6"><?php echo date($dateFormat, (int)$userPost['time']); ?></span>
              <a class="col-6" href="http://<?php echo parse_url($userPost['link'], PHP_URL_HOST); ?>">(<?php echo parse_url($userPost['link'], PHP_URL_HOST); ?>)</a>
            </div>
            <div class="row">
              <p class="col-12 mb-0"><?php echo ($userPost['description']!=null && strlen($userPost['description']) < 105)?(substr($userPost['description'], 0, 105). '...'):($userPost['description']) ?></p>
            </div>
            <div class="row">
              <a href="?page=user&user=<?php echo $username ?>" class="col-8">/u/<?php echo $username ?></a>
              <a href="?page=post&post=<?php echo $userPost['post_id'] ?>"class="col-4">comments(<?php echo $commentCount ?>)</a>
            </div>
          </div>
        </div>
        <hr>
        <?php
    }
}
