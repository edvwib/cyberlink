<?php
declare(strict_types=1);

$post = $pdo->prepare("SELECT * FROM posts WHERE post_id=:post_id AND user_id=:user_id");
$post->bindParam(':post_id', $_GET['post'], PDO::PARAM_INT);
$post->bindParam(':user_id', $_SESSION['user']['user_id'], PDO::PARAM_INT);
$post->execute();
$post = $post->fetch(PDO::FETCH_ASSOC);
if (!$post)
{
    die(var_dump($pdo->errorInfo()));
}
?>

<form class="editPost" action="/../../app/posts/editPost.php" method="post">

    <h3>Edit your post:</h3>
    <input type="hidden" name="post_id" value="<?php echo $_GET['post']; ?>">
    <div class="form-group">
        <input class="col-6 form-control" type="text" name="link" value="<?php echo $post['link'] ?>" required>
    </div>
    <?php if (isset($_SESSION['forms']['invalidLink']) && $_SESSION['forms']['invalidLink']): ?>
        <p class="col-3 bg-warning text-white">The link you've entered is invalid, please try again.</p>
        <?php $_SESSION['forms']['invalidLink'] = false; ?>
    <?php endif; ?>
    <div class="form-group">
        <input class="col-6 form-control" type="text" name="title" value="<?php echo $post['title'] ?>" required>
    </div>
    <div class="form-group">
        <textarea class="col-6 form-control" type="text" name="description" rows="3"><?php echo $post['description'] ?></textarea>
    </div>
    <button class="col-6 btn" type="submit" name="submit">Update</button>
</form>
