'use strict';

function pageNav(burger)
{
	var pageNav = document.getElementById("pageNav");

	pageNav.hidden = pageNav.hidden ? false : true;
	burger.classList.toggle("change");
}

function ggOpenForm() {
  form.style.display = "block"
}

function ggDeactive() {
  let reinitBtn = document.getElementById('reinitBtn2')
  let aBtns = reinitBtn.parentElement.getElementsByTagName('a')

 	for (let btn of aBtns) {
 	  btn.classList = 'w3-button w3-section gg-post-it'
  }
}

function ggActivate(element) {
  element.classList = 'w3-button w3-section w3-grey gg-post-it'
}

function ggSignupBtn() {
	login.style.display = 'none'
  reinit.style.display = 'none'
	signup.style.display = 'block'
  ggDeactive(this)
  ggActivate(this)
}

function ggLoginBtn() {
	signup.style.display = 'none'
  reinit.style.display = 'none'
	login.style.display = 'block'
  ggDeactive(this)
  ggActivate(this)
}

function ggReinitBtn() {
  let reinitBtn = document.getElementById('reinitBtn2')

	signup.style.display = 'none'
	login.style.display = 'none'
  reinit.style.display = 'block'
  ggDeactive(this)
  ggActivate(reinitBtn)
}

function ggCloseForm() {
  form.style.display='none'
}

function ggNavbar() {
  let form = document.getElementById('form')
  let login = document.getElementById('login')
  let signup = document.getElementById('signup')
  let reinit = document.getElementById('reinit')
  let reinitBtn = document.getElementById('reinitBtn2')

	document.getElementById('loginBtn').addEventListener('click', ggLoginBtn)
	document.getElementById('signupBtn').addEventListener('click', ggSignupBtn)
  document.getElementById('logBtn').addEventListener('click', ggOpenForm)
  document.getElementById('closeBtn').addEventListener('click', ggCloseForm)
  document.getElementById('reinitBtn').addEventListener('click', ggReinitBtn)
  reinitBtn2.addEventListener('click', ggReinitBtn)
}
