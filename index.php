<?php
declare(strict_types=1);

require_once __DIR__.'/views/header.php';

$posts = $pdo->query("SELECT * FROM posts");
$posts = $posts->fetchAll(PDO::FETCH_ASSOC);


?>

<?php foreach ($posts as $post): ?>
    <div class="post">
        <a href="<?php echo $post['link'] ?>"><?php echo $post['title']; ?></a>
        <a href="http://<?php echo parse_url($post['link'], PHP_URL_HOST); ?>">(<?php echo parse_url($post['link'], PHP_URL_HOST); ?>)</a>
    </div>
<?php endforeach; ?>

<?php require __DIR__.'/views/footer.php'; ?>
