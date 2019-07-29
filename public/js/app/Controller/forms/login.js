import { FormModal } from '../../Abstract/formModal.js'
import { printNotif } from '../../../Library/printnotif.js'

export class Login extends FormModal {
	constructor (state) {
		super(state, "login", "authForm")
		this.logBtnG = document.getElementById('logBtnG')
		this.redirect = ''
	}

	reset () {
		this.redirect = ''
	}

	toggleLoginButton () {
		this.logBtnG.href = '#logout'
		this.logBtnG.className = "w3-bar-item w3-black w3-button"
	}

	callback (response, httpStatus) {
		if (response['flash']) {
			printNotif(response['flash'], httpStatus)
		}
		if (response.settings) {
			let redirection = '#' + this.redirect
			console.log("redirection : " + redirection)

			this.state.setLogin(response.settings.pseudo)
			this.toggleLoginButton()
			this.reset()
			this.shutDown()
			window.location.assign(redirection)
		}
	}
}
