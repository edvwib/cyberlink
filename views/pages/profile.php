<?php
declare(strict_types=1);

require_once __DIR__.'/../header.php';

$profile = $pdo->prepare("SELECT email, username, user_id, bio FROM users WHERE user_id=:user_id");
$profile->bindParam(':user_id', $_SESSION['user_id']);
$profile->execute();
$profile = $profile->fetch(PDO::FETCH_ASSOC);
?>

<div class="profile-avatar my-3">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 panel">
        <form class="row" action="/../../app/profile/changeAvatar.php" method="post" enctype="multipart/form-data">
            <h4 class="col-10 offset-1">Avatar</h4>
            <div class="col-10 offset-1 text-center">
            <?php if (file_exists(__DIR__.'/../../assets/profiles/'.$profile['user_id'].'.png')): ?>
                <img src="/../../assets/profiles/<?php echo $profile['user_id'] ?>.png" class="col-8 col-lg-6 col-xl-4 rounded" alt="avatar">
            <?php else: ?>
                <img src="/../../assets/profiles/0.png" class="col-8 col-lg-6 col-xl-4 rounded" alt="avatar">
            <?php endif; ?>
            </div>
            <label class="col-10 offset-1" for="avatar">Choose your avatar image to upload (Max 10MB, .jpg, .jpeg, .png):</label>
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

<div class="profile-bio my-3">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 panel">
        <form class="row" action="/../../app/profile/changeBio.php" method="post">
            <h4 class="col-10 offset-1">Biography</h4>
            <textarea class="col-10 offset-1 form-control" maxlength="400" name="bio" rows="4" cols="80" placeholder="Write something about yourself!"><?php echo $profile['bio'] ?></textarea>
            <span class="col-10 offset-1"><span id="bioCount"></span> characters left.</span>
            <?php if (isset($_SESSION['forms']['bioUpdated']) && $_SESSION['forms']['bioUpdated']): ?>
                <p class="col-10 offset-1 bg-success text-white formError">Successfully updated biography.</p>
                <?php $_SESSION['forms']['bioUpdated'] = false; ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['forms']['bioTooLong']) && $_SESSION['forms']['bioTooLong']): ?>
                <p class="col-10 offset-1 bg-danger text-white formError">Biography exceeded the maximum length(400).</p>
                <?php $_SESSION['forms']['bioTooLong'] = false; ?>
            <?php endif; ?>
            <button class="col-10 offset-1 btn" type="submit" name="submit">Update biography</button>
        </form>
    </div>
</div>

<div class="profile-email my-3">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 panel">
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

<div class="profile-password my-3">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 panel">
        <form class="row" action="/../../app/profile/changePassword.php" method="post">
            <h4 class="col-10 offset-1">Password</h4>
            <input class="col-10 offset-1 form-control" type="password" name="old-password" placeholder="old password" autocomplete="off" required>
            <input class="col-10 offset-1 form-control" type="password" name="new-password1" placeholder="new password" required>
            <input class="col-10 offset-1 form-control" type="password" name="new-password2" placeholder="repeat new password" required>            
            <?php if (isset($_SESSION['forms']['passwordUpdated']) && $_SESSION['forms']['passwordUpdated']): ?>
                <p class="col-10 offset-1 bg-success text-white formError">Successfully updated your password.</p>
                <?php $_SESSION['forms']['passwordUpdated'] = false; ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['forms']['updatePassFailed']) && $_SESSION['forms']['updatePassFailed']): ?>
                <p class="col-10 offset-1 bg-danger text-white formError">Incorrect password.</p>
                <?php $_SESSION['forms']['updatePassFailed'] = false; ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['forms']['updatePassNotSame']) && $_SESSION['forms']['updatePassNotSame']): ?>
                <p class="col-10 offset-1 bg-danger text-white formError">The new passwords did not match.</p>
                <?php $_SESSION['forms']['updatePassNotSame'] = false; ?>
            <?php endif; ?>
            <button class="col-10 offset-1 btn" type="submit" name="submit">Update password</button>
        </form>
    </div>
</div>
