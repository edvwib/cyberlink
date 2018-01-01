<?php
declare(strict_types=1);

if (substr($_SERVER['QUERY_STRING'],0,4) !== "page") { //If URL !contain page var
    $query = ['page' => 'start',];
}else { //If
    parse_str($_SERVER['QUERY_STRING'], $query); //Auto parse query with parse_str
}

require_once __DIR__.'/views/header.php';

$votes = $pdo->query("SELECT * FROM user_votes");
$votes = $votes->fetchAll(PDO::FETCH_ASSOC);
var_dump($votes);


switch ($query['page']) {
    case 'start':
    $posts = $pdo->query("SELECT * FROM posts");
    $posts = $posts->fetchAll(PDO::FETCH_ASSOC);
    foreach ($posts as $post) {
        $up = $pdo->prepare("SELECT vote_type FROM user_votes WHERE post_id=:post_id AND vote_type=1 GROUP BY vote_type");
        $up->bindParam(':post_id', $post['post_id'], PDO::PARAM_INT);
        $up->execute();
        $up = $up->fetchAll(PDO::FETCH_ASSOC);
        $up = sizeof($up);

        $down = $pdo->prepare("SELECT vote_type FROM user_votes WHERE post_id=:post_id AND vote_type=0 GROUP BY vote_type");
        $down->bindParam(':post_id', $post['post_id'], PDO::PARAM_INT);
        $down->execute();
        $down = $down->fetchAll(PDO::FETCH_ASSOC);
        $down = sizeof($down);

        $score = $up-$down;
        ?>
        <div class="post">
            <div class="score"><?php echo $score ?></div>
            <h3><a href="<?php echo $post['link'] ?>"><?php echo $post['title']; ?></a></h3>
            <a href="http://<?php echo parse_url($post['link'], PHP_URL_HOST); ?>">(<?php echo parse_url($post['link'], PHP_URL_HOST); ?>)</a><br>
            <a href="?page=post&post=<?php echo $post['post_id'] ?>">comments</a>
        </div>
        <?php
    }
        break;
    case 'post':
        require_once __DIR__.'/views/pages/post.php';
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

    default:

        break;
}

?>



<?php require_once __DIR__.'/views/footer.php'; ?>
