<?php
declare(strict_types=1);
?>

<ul class="nav nav-pills flex-column flex-sm-row justify-content-center">
    <li class="nav-item">
        <a class="nav-link <?php if($query['page'] === 'start'){echo 'active';} ?>" href="/">Frontpage</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if($query['page'] === 'newpost'){echo 'active';} ?>" href="?page=newpost">New post</a>
    </li>
    <?php if ($_SESSION['authenticated']): ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle <?php if($query['page'] === 'user' || $query['page'] === 'profile'){echo 'active';} ?>" href="?page=user&user=<?php echo $_SESSION['user']['username'] ?>" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">You (<?php echo $_SESSION['user']['username'] ?>)</a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="?page=profile">Edit profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="?page=logout">Logout</a>
            </div>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <a class="nav-link <?php if($query['page'] === 'login'){echo 'active';} ?>" href="?page=login">Login/register</a>
        </li>
    <?php endif; ?>
</ul>
