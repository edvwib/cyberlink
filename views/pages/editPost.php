<?php
declare(strict_types=1);

require_once __DIR__.'/../header.php';

$post = $pdo->prepare("SELECT * FROM posts WHERE post_id=:post_id AND user_id=:user_id");
$post->bindParam(':post_id', $_GET['post'], PDO::PARAM_INT);
$post->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$post->execute();
$post = $post->fetch(PDO::FETCH_ASSOC);
if (!$post) { //unauthorized user
    redirect("/?page=newpost");
}
?>

<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 panel">
      <form class="row editPost" action="/../../app/posts/editPost.php" method="post">
          <h4 class="col-10 offset-1">Edit your post:</h4>
          <input type="hidden" name="post_id" value="<?php echo $_GET['post']; ?>">
          <div class="col-10 offset-1 form-group">
              <input class="form-control" type="text" name="link" value="<?php echo $post['link'] ?>" required>
          </div>
          <div class="col-10 offset-1 form-group">
              <input class="form-control" type="text" name="title" value="<?php echo $post['title'] ?>" required>
          </div>
          <div class="col-10 offset-1 form-group">
              <textarea class="form-control" type="text" name="description" rows="3"><?php echo $post['description'] ?></textarea>
          </div>
          <?php if (isset($_SESSION['forms']['invalidPost']) && $_SESSION['forms']['invalidPost']): ?>
              <div class="col-10 offset-1 form-group">
                  <p class="bg-danger text-white formError">Please enter at least a link and a title.</p>
              </div>
              <?php $_SESSION['forms']['invalidPost'] = false; ?>
          <?php endif; ?>
          <div class="col-10 offset-1 form-group">
              <button class="col-12 btn" type="submit" name="submit">Update</button>
          </div>
      </form>
    </div>
</div>
