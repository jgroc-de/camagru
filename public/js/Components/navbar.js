'use strict';

function ggNavbar() {
	let authForm = document.getElementById('form')
	let views
	let btns

	init()

	function init() {
		views = getFormViews()
		btns = getFormBtns()

		document.getElementById('logBtn').addEventListener('click', openForm)
		document.getElementById('closeBtn').addEventListener('click', closeForm)
	}

	function pageNav(burger)
	{
		var pageNav = document.getElementById("pageNav");

		pageNav.hidden = pageNav.hidden ? false : true;
		burger.classList.toggle("change");
	}

	function openForm() {
		authForm.style.display = "block"
	}

	function closeForm() {
		authForm.style.display = "none"
	}

	function deactive() {
		for (let btn of btns) {
			btn.classList = 'w3-button w3-section gg-post-it'
		}
	}

	function activate(element) {
		element.classList = 'w3-button w3-section w3-grey gg-post-it'
	}

	function hide() {
		for (let view of views) {
			view.style.display = 'none'
		}
	}

	function switchForm(element, view) {
		hide()
		deactive()
		activate(element)
		view.style.display = 'block'
	}

	function loginForm() {
		switchForm(this, views[0])
	}

	function signupForm() {
		switchForm(this, views[1])
	}

	function reinitForm() {
		switchForm(this, views[2])
	}

	function getFormViews() {
		let login = document.getElementById('login')
		let signup = document.getElementById('signup')
		let reinit = document.getElementById('reinit')

		return [login, signup, reinit]
	}

	function getFormBtns() {
		let reinitBtn = document.getElementById('reinitBtn')
		let signupBtn = document.getElementById('signupBtn')
		let loginBtn = document.getElementById('loginBtn')
		let reinitBtnAlt = document.getElementById('reinitBtnAlt')

		loginBtn.addEventListener('click', loginForm)
		signupBtn.addEventListener('click', signupForm)
		reinitBtn.addEventListener('click', reinitForm)
		reinitBtnAlt.addEventListener('click', reinitForm)

		return [loginBtn, signupBtn, reinitBtn, reinitBtnAlt]
	}
}
