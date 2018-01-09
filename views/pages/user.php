<?php
declare(strict_types=1);

if (isset($_GET['user'])) {
    $username = filter_var($_GET['user'], FILTER_SANITIZE_STRING);

    $userID = $pdo->prepare("SELECT user_id FROM users WHERE username=:username");
    $userID->bindParam(':username', $username, PDO::PARAM_STR);
    $userID->execute();
    $userID = $userID->fetchAll(PDO::FETCH_ASSOC);
    $userID = $userID[0]['user_id'];

    $userPosts = $pdo->prepare("SELECT * FROM posts WHERE user_id=:user_id");
    $userPosts->bindParam(':user_id', $userID, PDO::PARAM_INT);
    $userPosts->execute();
    $userPosts = $userPosts->fetchAll(PDO::FETCH_ASSOC);
}

foreach ($userPosts as $UserPost) {
    $score = getPostScoreByID($UserPost['post_id'], $pdo);
    ?>
    <div class="post">
        <div class="score"><?php echo $score ?></div>
        <h3><a href="<?php echo $UserPost['link'] ?>"><?php echo $UserPost['title']; ?></a></h3>
        <a href="http://<?php echo parse_url($UserPost['link'], PHP_URL_HOST); ?>">(<?php echo parse_url($UserPost['link'], PHP_URL_HOST); ?>)</a>
        <?php echo $spacer ?>
        <a href="?page=post&post=<?php echo $UserPost['post_id'] ?>">comments</a>
        <?php if ($username === $_SESSION['user']['username']): ?>
            <span>asd</span>
        <?php endif; ?>
    </div>
    <?php
}
