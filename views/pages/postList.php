<?php
declare(strict_types=1);

$posts = $pdo->query("SELECT * FROM posts");
$posts = $posts->fetchAll(PDO::FETCH_ASSOC);

foreach ($posts as $post) {
    $score = getPostScore($post['post_id'], $pdo);
    $user = getUser($post['user_id'], $pdo);
    ?>
    <div class="row">
        <div class="col-8 offset-2 post">
            <span class="col-1 h4 score"><?php echo ($score===1)?($score.'pt'):($score.'pts') ?></span>
            <span class="col-11 h2"><a href="<?php echo $post['link'] ?>"><?php echo $post['title']; ?></a></span>
            <a class="h6" href="http://<?php echo parse_url($post['link'], PHP_URL_HOST); ?>">(<?php echo parse_url($post['link'], PHP_URL_HOST); ?>)</a>
            <blockquote class="blockquote">
                <p class="mb-0"><?php echo $post['description'] ?></p>
                <a href="?page=user&user=<?php echo $user ?>" class="blockquote-footer">/u/<?php echo $user ?></a>
            </blockquote>
            <h5 class="col-2"><a href="?page=post&post=<?php echo $post['post_id'] ?>">comments</a></h5>
        </div>
    </div>
    <?php
}
