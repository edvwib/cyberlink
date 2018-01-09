<?php
declare(strict_types=1);

$profile = $pdo->prepare("SELECT email, username, password, bio FROM users WHERE user_id=:user_id");
$profile->bindParam(':user_id', $_SESSION['user']['user_id']);
$profile->execute();
$profile = $profile->fetch(PDO::FETCH_ASSOC);

$avatar = getAvatar($pdo);

?>

<div class="row profile-email">
    <div class="col-10 offset-1 panel">
        <h4 class="">Email</h4>
        <input class="" type="email" name="current-email" value="<?php echo $profile['email'] ?>" disabled>
    </div>
</div>

<div class="row profile-username">
    <div class="col-10 offset-1 panel">
        <h4 class="">Username</h4>
        <input class="" type="text" name="current-username" value="<?php echo $profile['username'] ?>" disabled>
    </div>
</div>

<div class="row profile-avatar">
    <div class="col-10 offset-1 panel">
        <h4 class="">Avatar</h4>
        <?php if ($avatar === null): ?>
            <img class="edit-profile-image" src="/../../assets/default-avatar.png" alt="avatar">
        <?php else: ?>
            <img class="edit-profile-image" src="data:image;base64,<?php echo $avatar ?>" alt="avatar">
        <?php endif; ?>
        <form class="" action="/../../app/profile/changeAvatar.php" method="post" enctype="multipart/form-data">
            <label class="col-10" for="avatar">Choose your avatar image to upload (Max 10MB, .jpg, .jpeg, .png, .gif):</label>
            <input class="col-4" type="file" accept=".jpg, .jpeg, .png, .gif" name="avatar" required>
            <button type="submit">Upload</button>
        </form>
    </div>
</div>

<div class="row profile-bio">
    <div class="col-10 offset-1 panel">
        <h4 class="">Biography</h4>
        <?php if ($profile['bio'] === null): ?>
            <textarea name="bio" rows="4" cols="80" placeholder="Write something about yourself!"></textarea>
        <?php else: ?>
            <textarea name="bio" rows="4" cols="80" placeholder="Write something about yourself!"><?php echo $profile['bio'] ?></textarea>
        <?php endif; ?>
    </div>
</div>
