<?php
declare(strict_types=1);
?>

<div class="row">
    <div class="col-5 offset-1 login">
        <a href="#" class="col-12 btn btn-primary login-btn active">Log in:</a>
    </div>
    <div class="col-5 register">
        <a href="#" class="col-12 btn btn-primary register-btn">Register:</a>
    </div>
</div>
<br>
<div class="row">
    <div class="col-12">
      <form class="row login-form" action="/../../app/auth/login.php" method="post">
          <?php if (isset($_SESSION['forms']['failedAuth']) && $_SESSION['forms']['failedAuth']): ?>
              <div class="col-10 offset-1 form-group">
                  <p class="col-12 bg-warning formError">Wrong username or password.</p>
              </div>
              <?php $_SESSION['forms']['failedAuth'] = false;?>
          <?php endif; ?>
          <div class="col-10 offset-1 form-group">
              <input class="form-control" type="text" name="username" placeholder="Username..." required>
          </div>
          <div class="col-10 offset-1 form-group">
              <input class="form-control" type="password" name="password" placeholder="Password..." required>
          </div>
          <div class="col-10 offset-1 form-group">
              <button class="col-12 btn" type="submit" name="submit">Log in</button>
          </div>
      </form>

      <form class="row register-form hidden" action="/../../app/auth/createAccount.php" method="post">
          <div class="col-10 offset-1 form-group">
              <input class="form-control" type="email" name="email" placeholder="Email..." required>
          </div>
          <div class="col-10 offset-1 form-group">
              <input class="form-control" type="text" name="username" placeholder="Username..." autocomplete="off" required>
          </div>
          <div class="col-10 offset-1 form-group">
              <input class="form-control" type="password" name="password" placeholder="Password..." required>
          </div>
          <div class="col-10 offset-1 form-group">
              <button class="col-12 btn" type="submit" name="submit">Create account</button>
          </div>
      </form>
    </div>
</div>
