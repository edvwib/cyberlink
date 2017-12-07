<?php
declare(strict_types=1);
?>
<nav>
  <li><a href="?page=frontpage">Frontpage</a></li>
  <?php if (!empty($_SESSION['user'])): ?>
    <li><a href="#">Logout</a></li>
  <?php else: ?>
    <li><a href="?page=login">Login/register</a></li>
  <?php endif; ?>
</nav>
