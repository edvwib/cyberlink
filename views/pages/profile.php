<?php
declare(strict_types=1);

$profile = $pdo->prepare("SELECT email, username, password, bio FROM users WHERE user_id=:user_id");
$profile->bindParam(':user_id', $_SESSION['user']['user_id']);
$profile->execute();
$profile = $profile->fetch(PDO::FETCH_ASSOC);

$avatar = getAvatarByID($_SESSION['user']['user_id'], $pdo);

?>

<div class="row profile-email">
    <div class="col-10 offset-1 panel">
        <h4 class="">Email</h4>
        <input class="form-control col-3" type="email" name="current-email" value="<?php echo $profile['email'] ?>" disabled>
        <form action="/../../app/profile/changeEmail.php" method="post">
            <input class="form-control col-3" type="email" name="new-email" placeholder="new email" required>
            <?php if (isset($_SESSION['forms']['changeEmailInvalid']) && $_SESSION['forms']['changeEmailInvalid']): ?>
                <p class="col-3 bg-warning text-white">Invalid email.</p>
                <?php $_SESSION['forms']['changeEmailInvalid'] = false; ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['forms']['emailUpdated']) && $_SESSION['forms']['emailUpdated']): ?>
                <p class="col-3 bg-success text-white">Successfully updated email.</p>
                <?php $_SESSION['forms']['emailUpdated'] = false; ?>
            <?php endif; ?>
            <button class="col-2 btn" type="submit" name="submit">Update email</button>
        </form>
    </div>
</div>

<div class="row profile-username">
    <div class="col-10 offset-1 panel">
        <h4 class="">Username</h4>
        <form action="/../../app/profile/changeUsername.php" method="post">
            <input class="form-control col-3" type="text" name="current-username" value="<?php echo $profile['username'] ?>" disabled>
            <input class="form-control col-3" type="text" name="new-username" placeholder="new username" required>
            <?php if (isset($_SESSION['forms']['usernameUpdated']) && $_SESSION['forms']['usernameUpdated']): ?>
                <p class="col-3 bg-success text-white">Successfully updated email.</p>
                <?php $_SESSION['forms']['usernameUpdated'] = false; ?>
            <?php endif; ?>
            <button class="col-2 btn" type="submit" name="submit">Update username</button>
        </form>
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
        <form action="/../../app/profile/changeAvatar.php" method="post" enctype="multipart/form-data">
            <label class="col-12" for="avatar">Choose your avatar image to upload (Max 10MB, .jpg, .jpeg, .png, .gif):</label>
            <input class="col-12 btn" type="file" accept="image/*" name="avatar" required>
            <?php if (isset($_SESSION['forms']['avatarSizeLimit']) && $_SESSION['forms']['avatarSizeLimit']): ?>
                <p class="col-3 bg-warning text-white">The uploaded file exceeded the file size limit (10MB).</p>
                <?php $_SESSION['forms']['avatarSizeLimit'] = false; ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['forms']['avatarInvalidType']) && $_SESSION['forms']['avatarInvalidType']): ?>
                <p class="col-3 bg-warning text-white">The uploaded file is not in a valid format.</p>
                <?php $_SESSION['forms']['avatarInvalidType'] = false; ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['forms']['avatarUpdated']) && $_SESSION['forms']['avatarUpdated']): ?>
                <p class="col-3 bg-success text-white">Successfully updated avatar.</p>
                <?php $_SESSION['forms']['avatarUpdated'] = false; ?>
            <?php endif; ?>
            <button class="col-2 btn" type="submit">Upload</button>
        </form>
    </div>
</div>

<div class="row profile-bio">
    <div class="col-10 offset-1 panel">
        <h4 class="">Biography</h4>
        <form action="/../../app/profile/changeBio.php" method="post">
            <textarea class="form-control col-6" name="bio" rows="4" cols="80" placeholder="Write something about yourself!" required><?php echo $profile['bio'] ?></textarea>
            <?php if (isset($_SESSION['forms']['bioUpdated']) && $_SESSION['forms']['bioUpdated']): ?>
                <p class="col-3 bg-success text-white">Successfully updated biography.</p>
                <?php $_SESSION['forms']['bioUpdated'] = false; ?>
            <?php endif; ?>
            <button class="col-2 btn" type="submit" name="submit">Update biography</button>
        </form>
    </div>
</div>
