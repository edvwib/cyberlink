<?php
declare(strict_types=1);

require_once __DIR__.'/../../views/header.php';

$posts = $pdo->query("SELECT * FROM posts");
$posts = $posts->fetchAll(PDO::FETCH_ASSOC);
foreach ($posts as $post) {
    $score = getPostScore($post['post_id'], $pdo);
    var_dump($score);
    ?>
    <div class="post">
        <div class="score"><?php echo $score ?></div>
        <h3><a href="<?php echo $post['link'] ?>"><?php echo $post['title']; ?></a></h3>
        <a href="http://<?php echo parse_url($post['link'], PHP_URL_HOST); ?>">(<?php echo parse_url($post['link'], PHP_URL_HOST); ?>)</a><br>
        <a href="?page=post&post=<?php echo $post['post_id'] ?>">comments</a>
    </div>
    <?php
}
