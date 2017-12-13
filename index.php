<?php
declare(strict_types=1);

require_once __DIR__.'/views/header.php';

$posts = $pdo->query("SELECT * FROM posts");
$posts = $posts->fetchAll(PDO::FETCH_ASSOC);


if (substr($_SERVER['QUERY_STRING'],0,4) !== "page") { //If URL !contain page var
    $query = ['page' => 'start',];
}else { //If
    parse_str($_SERVER['QUERY_STRING'], $query); //Auto parse query with parse_str
}
?>

<?php

switch ($query['page']) {
    case 'start':
    foreach ($posts as $post) {
        ?>
        <div class="post">
            <a href="<?php echo $post['link'] ?>"><?php echo $post['title']; ?></a>
            <a href="http://<?php echo parse_url($post['link'], PHP_URL_HOST); ?>">(<?php echo parse_url($post['link'], PHP_URL_HOST); ?>)</a>
        </div>
        <?php
    }
        break;
    case 'newpost':
        require_once __DIR__.'/views/pages/newPost.php';
        break;
    case 'login':
        require_once __DIR__.'/views/pages/login.php';
        break;
    case 'logout':
        header('Location: /app/auth/logout.php');
        break;

    default: //Default to displaying all posts

        break;
}

 ?>

<?php foreach ($posts as $post): ?>

<?php endforeach; ?>

<?php require __DIR__.'/views/footer.php'; ?>
