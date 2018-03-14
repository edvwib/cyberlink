<?php
declare(strict_types=1);

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
    $currentUser = getUserByID($_SESSION['user_id'], $pdo);
}
?>

<nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-2">
    <a class="navbar-brand" href="/">Cyberlink</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link <?php echo ($query['page']==='start')?('active'):('') ?>" href="/">Frontpage</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($query['page']==='newpost')?('active'):('') ?>" href="?page=newpost">New post</a>
            </li>
            <?php if ($_SESSION['authenticated']): ?>
                <li class="nav-item <?php echo ($query['page']==='user' || $query['page']==='profile')?('active'):('') ?> dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    You (<?php echo $currentUser ?>)
                    </a>
                    <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item <?php echo ($query['page']==='user')?('selected'):('') ?>" href="?page=user&user=<?php echo $currentUser ?>">You</a>
                        <a class="dropdown-item <?php echo ($query['page']==='profile')?('selected'):('') ?>" href="?page=profile">Edit profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item navbar-gray" href="?page=logout">Log out</a>
                    </div>
                </li>
            <?php else: ?>
                <li class="nav-item <?php echo ($query['page']==='login')?('active'):('') ?>">
                    <a class="nav-link" href="?page=login">Log in/register</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
