<?php
declare(strict_types=1);

$posts = $pdo->query("SELECT * FROM posts");
$posts = $posts->fetchAll(PDO::FETCH_ASSOC);

foreach ($posts as $post) {
    $score = getPostScoreByID($post['post_id'], $pdo);
    $user = getUserByID($post['user_id'], $pdo);
    $commentCount = getCommentCountByID($post['post_id'], $pdo);
    ?>
    <div class="row">
        <div class="col-8 offset-2 post">
            <span class="col-1 h4 score"><?php echo ($score===1)?($score.'pt'):($score.'pts') ?></span>
            <a class="col-11 h3" href="<?php echo $post['link'] ?>"><?php echo $post['title']; ?></a>
            <a class="h6" href="http://<?php echo parse_url($post['link'], PHP_URL_HOST); ?>">(<?php echo parse_url($post['link'], PHP_URL_HOST); ?>)</a>
            <blockquote class="col-12 mb-0 blockquote">
                <p class="mb-0"><?php echo ($post['description']!=null && strlen($post['description']) < 105)?(substr($post['description'], 0, 105). '...'):($post['description']) ?></p>
            </blockquote>
            <a class="col-2" href="?page=user&user=<?php echo $user ?>">/u/<?php echo $user ?></a>
            <?php echo $spacer ?>
            <a class="col-2" href="?page=post&post=<?php echo $post['post_id'] ?>">comments(<?php echo $commentCount ?>)</a>
        </div>
    </div>
    <?php
}
