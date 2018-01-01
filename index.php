<?php
declare(strict_types=1);

if (substr($_SERVER['QUERY_STRING'],0,4) !== "page") { //If URL !contain page var
    $query = ['page' => 'start',];
}else { //If
    parse_str($_SERVER['QUERY_STRING'], $query); //Auto parse query with parse_str
}

require_once __DIR__.'/views/header.php';

switch ($query['page']) {
    case 'start':
    require_once __DIR__.'/views/pages/postList.php';
        break;
    case 'post':
        require_once __DIR__.'/views/pages/post.php';
        break;
    case 'newpost':
        require_once __DIR__.'/views/pages/newPost.php';
        break;
    case 'user':
        require_once __DIR__.'/views/pages/user.php';
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
