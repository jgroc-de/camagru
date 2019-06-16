import { hiddenFormController } from '../Abstract/hiddenFormController.js'

export class Login extends hiddenFormController {
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

	callback (response) {
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
