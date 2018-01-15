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

if (document.URL.indexOf("page=post") >= 0) { //On user page
  let deleteLink = document.querySelector('#deletePost');
  deleteLink.addEventListener('click', (e) => {
    if (!confirm("Do you really want to delete this post?")) {
      e.preventDefault();
    }
  });
}
