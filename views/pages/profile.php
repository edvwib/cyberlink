<?php
declare(strict_types=1);

$profile = $pdo->prepare("SELECT email, username, password, bio FROM users WHERE user_id=:user_id");
$profile->bindParam(':user_id', $_SESSION['user']['user_id']);
$profile->execute();
$profile = $profile->fetch(PDO::FETCH_ASSOC);

$avatar = getAvatarByID(intval($_SESSION['user']['user_id']), $pdo);

?>

<div class="row profile-email my-3">
  <div class="col-12 panel">
      <form class="row" action="/../../app/profile/changeEmail.php" method="post">
        <h4 class="col-10 offset-1">Email</h4>
        <input class="col-10 offset-1 form-control" type="email" name="current-email" value="<?php echo $profile['email'] ?>" disabled>
        <input class="col-10 offset-1 form-control" type="email" name="new-email" placeholder="new email" required>
        <?php if (isset($_SESSION['forms']['emailUpdated']) && $_SESSION['forms']['emailUpdated']): ?>
          <p class="col-10 offset-1 bg-success text-white formError">Successfully updated email.</p>
          <?php $_SESSION['forms']['emailUpdated'] = false; ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['forms']['changeEmailSame']) && $_SESSION['forms']['changeEmailSame']): ?>
          <p class="col-10 offset-1 bg-warning text-white formError">You're already using that email.</p>
          <?php $_SESSION['forms']['changeEmailSame'] = false; ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['forms']['changeEmailInvalid']) && $_SESSION['forms']['changeEmailInvalid']): ?>
          <p class="col-10 offset-1 bg-warning text-white formError">Invalid email.</p>
          <?php $_SESSION['forms']['changeEmailInvalid'] = false; ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['forms']['changeEmailInUse']) && $_SESSION['forms']['changeEmailInUse']): ?>
          <p class="col-10 offset-1 bg-danger text-white formError">Email is already in use.</p>
          <?php $_SESSION['forms']['changeEmailInUse'] = false; ?>
        <?php endif; ?>
        <button class="col-10 offset-1 btn" type="submit" name="submit">Update email</button>
      </form>
  </div>
</div>

<div class="row profile-username my-3">
    <div class="col-12 panel">
        <form class="row" action="/../../app/profile/changeUsername.php" method="post">
            <h4 class="col-10 offset-1">Username</h4>
            <input class="col-10 offset-1 form-control" type="text" name="current-username" value="<?php echo $profile['username'] ?>" disabled>
            <input class="col-10 offset-1 form-control" type="text" name="new-username" placeholder="new username" autocomplete="off" required>
            <?php if (isset($_SESSION['forms']['usernameUpdated']) && $_SESSION['forms']['usernameUpdated']): ?>
                <p class="col-10 offset-1 bg-success text-white formError">Successfully updated your username.</p>
                <?php $_SESSION['forms']['usernameUpdated'] = false; ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['forms']['changeUsernameSame']) && $_SESSION['forms']['changeUsernameSame']): ?>
                <p class="col-10 offset-1 bg-warning text-white formError">You're already using that username.</p>
                <?php $_SESSION['forms']['changeUsernameSame'] = false; ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['forms']['usernameInUse']) && $_SESSION['forms']['usernameInUse']): ?>
                <p class="col-10 offset-1 bg-danger text-white formError">That username is already in use.</p>
                <?php $_SESSION['forms']['usernameInUse'] = false; ?>
            <?php endif; ?>
            <button class="col-10 offset-1 btn" type="submit" name="submit">Update username</button>
        </form>
    </div>
</div>

<div class="row profile-avatar my-3">
    <div class="col-12 panel">
        <form class="row" action="/../../app/profile/changeAvatar.php" method="post" enctype="multipart/form-data">
            <h4 class="col-10 offset-1">Avatar</h4>
            <div class="col-10 offset-1 text-center">
            <?php if ($avatar === null): ?>
                <img src="/../../assets/default-avatar.png" class="col-8 rounded" alt="avatar">
            <?php else: ?>
                <img src="data:image;base64,<?php echo $avatar ?>" class="col-8 rounded" alt="avatar">
            <?php endif; ?>
            </div>
            <label class="col-10 offset-1" for="avatar">Choose your avatar image to upload (Max 10MB, .jpg, .jpeg, .png, .gif):</label>
            <input class="col-10 offset-1 btn" type="file" accept="image/*" name="avatar" required>
            <?php if (isset($_SESSION['forms']['avatarUpdated']) && $_SESSION['forms']['avatarUpdated']): ?>
                <p class="col-10 offset-1 bg-success text-white formError">Successfully updated your avatar.</p>
                <?php $_SESSION['forms']['avatarUpdated'] = false; ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['forms']['avatarSizeLimit']) && $_SESSION['forms']['avatarSizeLimit']): ?>
                <p class="col-10 offset-1 bg-danger text-white formError">The uploaded file exceeded the file size limit (10MB).</p>
                <?php $_SESSION['forms']['avatarSizeLimit'] = false; ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['forms']['avatarInvalidType']) && $_SESSION['forms']['avatarInvalidType']): ?>
                <p class="col-10 offset-1 bg-danger text-white formError">The uploaded file is not in a valid format.</p>
                <?php $_SESSION['forms']['avatarInvalidType'] = false; ?>
            <?php endif; ?>
            <button class="col-10 offset-1 btn" type="submit">Upload</button>
        </form>
    </div>
</div>

<div class="row profile-bio my-3">
    <div class="col-12 panel">
        <form class="row" action="/../../app/profile/changeBio.php" method="post">
            <h4 class="col-10 offset-1">Biography</h4>
            <textarea class="col-10 offset-1 form-control" name="bio" rows="4" cols="80" placeholder="Write something about yourself!" required><?php echo $profile['bio'] ?></textarea>
            <?php if (isset($_SESSION['forms']['bioUpdated']) && $_SESSION['forms']['bioUpdated']): ?>
                <p class="col-10 offset-1 bg-success text-white formError">Successfully updated biography.</p>
                <?php $_SESSION['forms']['bioUpdated'] = false; ?>
            <?php endif; ?>
            <button class="col-10 offset-1 btn" type="submit" name="submit">Update biography</button>
        </form>
    </div>
</div>
