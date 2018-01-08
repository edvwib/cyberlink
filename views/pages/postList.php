<?php
declare(strict_types=1);

$posts = $pdo->query("SELECT * FROM posts");
$posts = $posts->fetchAll(PDO::FETCH_ASSOC);
foreach ($posts as $post) {
    $score = getPostScore($post['post_id'], $pdo);
    ?>

    <div class="row">
        <div class="col-8 offset-2">
            <span class="col-1 h4 score"><?php echo $score ?></span>
            <span class="col-11 h2"><a href="<?php echo $post['link'] ?>"><?php echo $post['title']; ?></a></span>
            <a class="h6" href="http://<?php echo parse_url($post['link'], PHP_URL_HOST); ?>">(<?php echo parse_url($post['link'], PHP_URL_HOST); ?>)</a>
            <h5 class="col-2"><a href="?page=post&post=<?php echo $post['post_id'] ?>">comments</a></h5>
        </div>
    </div>





    <?php
}
