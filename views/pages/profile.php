<?php
declare(strict_types=1);

$profile = $pdo->prepare("SELECT * FROM users WHERE user_id=:user_id");
$profile->bindParam(':user_id', $_SESSION['user']['user_id']);
$profile->execute();
$profile = $profile->fetch(PDO::FETCH_ASSOC);
var_dump($profile);

$avatar = getAvatar($profile[0]['avatar'], $pdo);

?>

<div class="row profile-email">
  <h4 class="col-10 offset-1">Email</h4>
  <input class="col-3 offset-1" type="email" name="current-email" value="<?php echo $profile['email'] ?>" disabled>
</div>

<div class="row profile-username">
  <h4 class="col-10 offset-1">Username</h4>
  <input class="col-3 offset-1" type="text" name="current-username" value="<?php echo $profile['username'] ?>" disabled>

</div>

<div class="row profile-avatar">
  <h4 class="col-10 offset-1">Avatar</h4>
  <img src="../../tmp/avatar.png" alt="avatar">
</div>

<div class="row profile-bio">
  <h4 class="col-10 offset-1">Biography</h4>
  <?php if ($profile['bio'] === null): ?>
    <textarea name="bio" rows="4" cols="80" placeholder="Write something about yourself!"></textarea>
  <?php else: ?>
    <textarea name="bio" rows="4" cols="80" placeholder="Write something about yourself!"><?php echo $profile['bio'] ?></textarea>
  <?php endif; ?>
</div>
