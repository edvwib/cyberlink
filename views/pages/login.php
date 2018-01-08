
<div class="row">
    <div class="col-2 login">
        <a href="#" class="col-12 btn btn-primary login-btn active">Login:</a>
    </div>
    <div class="col-2 register">
        <a href="#" class="col-12 btn btn-primary register-btn">Register:</a>
    </div>
</div>
<br>
<div class="row">
    <form class="col-6 login-form" action="/../../app/auth/login.php" method="post">
        <div class="form-group">
            <input class="col-6 form-control" type="text" name="username" placeholder="Username..." required>
        </div>
        <div class="form-group">
            <input class="col-6 form-control" type="password" name="password" placeholder="Password..." required>
        </div>
        <div class="form-group">
            <button class="col-6 btn" type="submit" name="submit">Log in</button>
        </div>
    </form>

    <form class="col-6 register-form hidden" action="/../../app/auth/createAccount.php" method="post">
        <div class="form-group">
            <input class="col-6 form-control" type="email" name="email" placeholder="Email..." required>
        </div>
        <div class="form-group">
            <input class="col-6 form-control" type="text" name="username" placeholder="Username..." required>
        </div>
        <div class="form-group">
            <input class="col-6 form-control" type="password" name="password" placeholder="Password..." required>
        </div>
        <div class="form-group">
            <button class="col-6 btn" type="submit" name="submit">Create account</button>
        </div>
    </form>
</div>
