<?php
declare(strict_types=1);
?>

<div class="row">
  <div class="col-8 offset-2">
    <?php if ($_SESSION['authenticated']): ?>
        <form class="newPost" action="/../../app/posts/newPost.php" method="post">
            <h3>Submit a new post:</h3>
            <div class="form-group">
                <input class="col-6 form-control" type="text" name="link" placeholder="Link..." required>
            </div>
            <div class="form-group">
                <input class="col-6 form-control" type="text" name="title" placeholder="Title..." required>
            </div>
            <div class="form-group">
                <textarea class="col-6 form-control" type="text" name="description" placeholder="Description..." rows="3"></textarea>
            </div>
            <?php if (isset($_SESSION['forms']['invalidPost']) && $_SESSION['forms']['invalidPost']): ?>
                <p class="col-6 bg-danger text-white">Please enter at least a link and a title.</p>
                <?php $_SESSION['forms']['invalidPost'] = false; ?>
            <?php endif; ?>
            <button class="col-6 btn" type="submit" name="submit">Post</button>
        </form>
    <?php else: ?>
        <p>You need to be <a href="?page=login">logged in</a> in order to create posts.</p>
    <?php endif; ?>
  </div>
</div>
