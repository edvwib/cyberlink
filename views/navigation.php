<?php
declare(strict_types=1);
?>
<nav>
  <li><a href="/">Frontpage</a></li>
  <li><a href="?page=newpost">New post</a></li>
  <?php if (isset($_SESSION['authenticated'])): ?>
    <li><a href="?page=logout">Logout</a></li>
  <?php else: ?>
    <li><a href="?page=login">Login/register</a></li>
  <?php endif; ?>
</nav>
