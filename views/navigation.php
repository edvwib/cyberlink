<?php
declare(strict_types=1);
?>
<nav>
  <li><a href="/">Frontpage</a></li>
  <li><a href="Newpost">New post</a></li>
  <?php if (isset($_SESSION['authenticated'])): ?>
    <li><a href="/../app/auth/logout.php">Logout</a></li>
  <?php else: ?>
    <li><a href="Login">Login/register</a></li>
  <?php endif; ?>
</nav>
