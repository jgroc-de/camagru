import { request } from '../../../Abstract/request.js'
import { ggAjax } from '../../../../Library/ggAjax.js'
import { printNotif } from '../../../../Library/printnotif.js'

export class LoginEvents {
  constructor(name, state) {
    this.state = state
    this.name = name
		this.buttons = []
  }

  init() {
		this.logBtnG = document.getElementById('logBtnG')
		this.formContainer = document.getElementById(this.name)
		this.handleEvent = function (event) {
			this.eventDispatcher(event)
		}
		this.setButtons()
		this.setEventListener()
  }

	eventDispatcher(event) {
    event.preventDefault()
    event.stopPropagation()

    this.submit(event)
  }

  setEventListener() {
    let i = 0

    while (i < this.buttons.length) {
      this.buttons[i++].addEventListener("click", this, false)
    }
  }

  addButtons (form) {
    let buttons = form.getElementsByTagName('button')

    for (let button of buttons) {
      if (button.type === 'submit') {
        this.buttons.push(button)
      }
    }
  }

  setButtons () {
    let forms = this.formContainer.getElementsByTagName('form')

    this.addButtons(forms[0])
  }

  submit (event) {
    let inputs = event.target.form

    if (inputs.checkValidity()) {
      ggAjax(new request(inputs), this)
    } else {
      console.log("valid: "+ inputs.checkValidity())
    }
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
      if (!this.redirect) {
        redirection = '#' + this.state.prevRoute
      }

			this.state.setLogin(response.settings)
			this.toggleLoginButton()
		  this.redirect = ''
			this.state.components.Login.shutDown()
			window.location.assign(redirection)
		}
	}
}
