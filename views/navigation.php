<?php
declare(strict_types=1);
?>

<ul class="nav flex-column flex-sm-row justify-content-center">
    <li class="nav-item">
        <a class="nav-link <?php if($query['page'] === 'start'){echo 'active';} ?>" href="/">Frontpage</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($query['page'] === 'newpost'){echo 'active';} ?>" href="?page=newpost">New post</a>
    </li>
    <?php if ($_SESSION['authenticated']): ?>
        <li class="nav-item">
            <a class="nav-link" href="?page=logout">Logout (<?php echo $_SESSION['user']['username'] ?></a>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <a class="nav-link <?php if($query['page'] === 'login'){echo 'active';} ?>" href="?page=login">Login/register</a>
        </li>
    <?php endif; ?>
</ul>
