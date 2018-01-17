<?php
declare(strict_types=1);

require_once __DIR__.'/../header.php';

?>

<div class="row">
    <div class="col-5 offset-1 col-sm-3 offset-sm-3 col-md-2 offset-md-4 login">
        <a href="#" class="col-12 btn btn-primary login-btn active">Log in:</a>
    </div>
    <div class="col-5 col-sm-3 col-md-2 register">
        <a href="#" class="col-12 btn btn-primary register-btn">Register:</a>
    </div>
</div>
<br>
<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">

      <form class="row login-form" action="/../../app/auth/login.php" method="post">
          <?php if (isset($_SESSION['forms']['failedAuth']) && $_SESSION['forms']['failedAuth']): ?>
              <div class="col-10 offset-1 form-group">
                  <p class="col-12 bg-warning formError">Wrong username or password.</p>
              </div>
              <?php $_SESSION['forms']['failedAuth'] = false;?>
          <?php endif; ?>
          <?php if (isset($_SESSION['forms']['accountCreated']) && $_SESSION['forms']['accountCreated']): ?>
              <p class="col-10 offset-1 bg-success text-white formError">Your account was created, please sign in below.</p>
              <?php $_SESSION['forms']['accountCreated'] = false; ?>
          <?php endif; ?>
          <div class="col-10 offset-1 form-group">
              <label for="username">Username:</label>
              <input type="text" class="form-control" name="username" placeholder="Username" required
                  value="<?php echo (isset($_SESSION['formInput']['username']))?($_SESSION['formInput']['username']):('') ?>">
          </div>
          <div class="col-10 offset-1 form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" name="password" placeholder="********" required>
          </div>
          <div class="col-10 offset-1 form-group">
              <button class="col-12 btn" type="submit" name="submit">Log in</button>
          </div>
      </form>

      <form class="row register-form hidden" action="/../../app/auth/createAccount.php" method="post">
          <?php if (isset($_SESSION['forms']['emailInvalid']) && $_SESSION['forms']['emailInvalid']): ?>
              <div class="col-10 offset-1 form-group">
                  <p class="col-12 bg-warning formError">The email is not in a valid format.</p>
              </div>
              <?php $_SESSION['forms']['emailInvalid'] = false;?>
          <?php endif; ?>
          <?php if (isset($_SESSION['forms']['emailInUse']) && $_SESSION['forms']['emailInUse']): ?>
              <div class="col-10 offset-1 form-group">
                  <p class="col-12 bg-warning formError">There's already an account registered with that email.</p>
              </div>
              <?php $_SESSION['forms']['emailInUse'] = false;?>
          <?php endif; ?>
          <?php if (isset($_SESSION['forms']['usernameInUse']) && $_SESSION['forms']['usernameInUse']): ?>
              <div class="col-10 offset-1 form-group">
                  <p class="col-12 bg-warning formError">There's already an account registered with that username.</p>
              </div>
              <?php $_SESSION['forms']['usernameInUse'] = false;?>
          <?php endif; ?>
          <?php if (isset($_SESSION['forms']['passwordInvalid']) && $_SESSION['forms']['passwordInvalid']): ?>
              <div class="col-10 offset-1 form-group">
                  <p class="col-12 bg-warning formError">The passwords you've entered do not match.</p>
              </div>
              <?php $_SESSION['forms']['passwordInvalid'] = false;?>
          <?php endif; ?>
          <div class="col-10 offset-1 form-group">
              <label for="email">Email:</label>
              <input type="text" class="form-control" name="email" placeholder="example@example.com" required
                  value="<?php echo (isset($_SESSION['formInput']['email']))?($_SESSION['formInput']['email']):('') ?>">
          </div>
          <div class="col-10 offset-1 form-group">
              <label for="username">Username:</label>
              <input type="text" class="form-control" name="username" autocomplete="off" placeholder="Username" required
                  value="<?php echo (isset($_SESSION['formInput']['username']))?($_SESSION['formInput']['username']):('') ?>">
          </div>
          <div class="col-10 offset-1 form-group">
              <label for="password1">Password:</label>
              <input type="password" class="form-control" name="password1" placeholder="********" required>
          </div>
          <div class="col-10 offset-1 form-group">
              <label for="password2">Repeat password:</label>
              <input type="password" class="form-control" name="password2" placeholder="********" required>
          </div>
          <div class="col-10 offset-1 form-group">
              <button class="col-12 btn" type="submit" name="submit">Create account</button>
          </div>
      </form>
    </div>
</div>
