'use strict';

function showLoginForm(){
  registerForm.classList.add('hidden');
  loginForm.classList.remove('hidden');
  registerBtn.classList.remove('active');
  loginBtn.classList.add('active');
}

function showRegisterForm(){
  loginForm.classList.add('hidden');
  registerForm.classList.remove('hidden');
  loginBtn.classList.remove('active');
  registerBtn.classList.add('active');
}
