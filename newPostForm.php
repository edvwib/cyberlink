<?php
declare(strict_types=1);

require_once __DIR__.'/views/header.php';

?>

<form class="newPost" action="/app/posts/newpost.php" method="post">
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

<?php require __DIR__.'/views/footer.php'; ?>
