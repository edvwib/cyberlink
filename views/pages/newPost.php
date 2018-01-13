<?php
declare(strict_types=1);
?>

<div class="row">
  <?php if ($_SESSION['authenticated']): ?>
    <div class="col-12 col-sm-8 offset-sm-2 panel">
        <form class="row newPost" action="/../../app/posts/newPost.php" method="post">
            <h4>Submit a new post:</h4>
            <div class="col-10 offset-1 form-group">
                <input class="form-control" type="text" name="link" placeholder="Link..." required>
            </div>
            <div class="col-10 offset-1 form-group">
                <input class="form-control" type="text" name="title" placeholder="Title..." required>
            </div>
            <div class="col-10 offset-1 form-group">
                <textarea class="form-control" type="text" name="description" placeholder="Description..." rows="3"></textarea>
            </div>
            <?php if (isset($_SESSION['forms']['invalidPost']) && $_SESSION['forms']['invalidPost']): ?>
                <div class="col-10 offset-1 form-group">
                    <p class="bg-danger text-white formError">Please enter at least a link and a title.</p>
                </div>
                <?php $_SESSION['forms']['invalidPost'] = false; ?>
            <?php endif; ?>
            <div class="col-10 offset-1 form-group">
                <button class="col-12 btn" type="submit" name="submit">Post</button>
            </div>
        </form>
      </div>
  <?php else: ?>
    <p class="col-12 col-sm-8 offset-sm-2">You need to be <a href="?page=login">logged in</a> in order to create posts.</p>
  <?php endif; ?>
</div>
