'use strict';

if (document.URL.indexOf("page=login") >= 0) {
  let loginBtn = document.querySelector('.login-btn');
  let registerBtn = document.querySelector('.register-btn');
  let loginForm = document.querySelector('.login-form');
  let registerForm = document.querySelector('.register-form');


  loginBtn.addEventListener('click', () => {
    registerForm.classList.add('hidden');
    loginForm.classList.remove('hidden');
    registerBtn.classList.remove('active');
    loginBtn.classList.add('active');
  });
  registerBtn.addEventListener('click', () => {
    loginForm.classList.add('hidden');
    registerForm.classList.remove('hidden');
    loginBtn.classList.remove('active');
    registerBtn.classList.add('active');
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
