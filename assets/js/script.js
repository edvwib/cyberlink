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
    document.querySelector('p.bg-warning').remove();
  });
}
