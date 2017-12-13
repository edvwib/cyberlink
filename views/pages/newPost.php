<?php
declare(strict_types=1);

require_once __DIR__.'/../header.php';

?>
<?php if ($_SESSION['authenticated']): ?>
    <form class="newPost" action="/../../app/posts/newpost.php" method="post">
        <p>New post:</p>
        <div>
            <label for="link">Link:</label>
            <input type="text" name="link" required>
        </div>
        <div>
            <label for="title">Title:</label>
            <input type="text" name="title" required>
        </div>
        <button type="submit" name="submit">Post</button>
    </form>
<?php else: ?>
    <p>You need to be <a href="?page=login">logged in</a> in order to create posts.</p>
<?php endif; ?>


<?php require __DIR__.'/../footer.php'; ?>
