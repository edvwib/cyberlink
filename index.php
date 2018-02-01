<?php
declare(strict_types=1);

if (substr($_SERVER['REQUEST_URI'],2,4) !== "page") { //If URL !contain page var
    $query = ['page' => 'start',];
}else {
    $start = strpos($_SERVER['REQUEST_URI'], '&');
    if (is_int($start)) { //If requested page has no subpage
        $query['page'] = (substr($_SERVER['REQUEST_URI'],7, $start-7));
    }
    else { //If page has subpage, get the value of it
        $query['page'] = (substr($_SERVER['REQUEST_URI'],7));
        $end = strpos($query['page'], '=');
        if (is_int($end)){
            $query['action'] = substr($query['page'], $start, $end-$start);
        }
    }
}

switch ($query['page']) {
    case 'start':
    require_once __DIR__.'/views/pages/postList.php';
        break;
    case 'post':
        if (isset($query['action'])) {
            switch ($query['action']) {
                case 'edit':
                    require_once __DIR__.'/views/pages/editPost.php';
                    break;
                case 'delete':
                    require_once __DIR__.'/app/posts/deletePost.php';
                    break;
                default:
                    redirect('/');
                    break;
            }
        }else {
            require_once __DIR__.'/views/pages/post.php';
        }
        break;
    case 'newpost':
        require_once __DIR__.'/views/pages/newPost.php';
        break;
    case 'user':
        require_once __DIR__.'/views/pages/user.php';
        break;
    case 'profile':
        require_once __DIR__.'/views/pages/profile.php';
        break;
    case 'login':
        require_once __DIR__.'/views/pages/login.php';
        break;
    case 'logout':
        require_once __DIR__.'/app/auth/logout.php';
        break;
    default:
        require_once __DIR__.'/views/pages/404.php';
        break;
}

die(var_dump(getTimeAgo(1451639194)));

require_once __DIR__.'/views/footer.php';
