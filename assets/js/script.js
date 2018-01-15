'use strict';

if (document.URL.indexOf("page=login") >= 0) {
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

if (document.URL.indexOf("page=profile") >= 0) {
  let bioTextarea = document.querySelector('.profile-bio textarea');
  let bioChars = document.querySelector('#bioCharsLeft');
  bioChars.textContent = 400 - bioTextarea.value.length;

  bioTextarea.addEventListener('keyup', (ev) => {
    bioChars.textContent = 400 - bioTextarea.value.length;
  });
}
