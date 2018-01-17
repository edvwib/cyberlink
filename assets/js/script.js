'use strict';

if (document.URL.indexOf("page=login") >= 0) { //On login/register page
  var loginBtn = document.querySelector('.login-btn');
  var registerBtn = document.querySelector('.register-btn');
  var loginForm = document.querySelector('.login-form');
  var registerForm = document.querySelector('.register-form');

  if (document.URL.indexOf("page=login&fail") >= 0) {
    showRegisterForm();
  }

  loginBtn.addEventListener('click', () => {
    showLoginForm();
  });
  registerBtn.addEventListener('click', () => {
    showRegisterForm();
  });
}

if (document.URL.indexOf("page=profile") >= 0) { //On profile page
  let bioTextarea = document.querySelector('.profile-bio textarea');
  let bioCount = document.querySelector('#bioCount');
  bioCount.textContent = 400 - bioTextarea.value.length;

  bioTextarea.addEventListener('keyup', (ev) => {
    bioCount.textContent = 400 - bioTextarea.value.length;
  });
}

if (document.URL.indexOf("page=post") >= 0) { //On post page
  let deletePostLink = document.querySelector('#deletePost');
  if (deletePostLink !== null) {
    deletePostLink.addEventListener('click', (e) => {
      if (!confirm("Do you really want to delete this post?")) {
        e.preventDefault();
      }
    });
  }
}

if (document.URL.indexOf("page=login") >= 0) { //On login page
  if (document.URL.indexOf("page=login&failed") >= 0) {
    showRegisterForm();
  }
  let passwordInputs = document.querySelectorAll('.register-form input[type="password"]');
  let submitBtn = document.querySelector('.register-form button[type="submit"]');
  submitBtn.disabled = true;
  submitBtn.textContent = 'Passwords do not match';

  console.log(passwordInputs);
  if (passwordInputs !== null) {
    passwordInputs[1].addEventListener('keyup', (e) => {
      if (passwordInputs[0].value === passwordInputs[1].value) {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Create account';
      }
      else {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Passwords do not match';
      }
    });
  }
}
