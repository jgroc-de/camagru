import { request } from '../../Library/request.js'
import { ggAjax } from '../../Library/ggAjax.js'
import { printNotif } from '../../Library/printnotif.js'

export class Login {
  constructor(name, state) {
    this.name = name
    this.state = state
		this.buttons = []
  }

  init(card) {
		this.logBtnG = document.getElementById('logBtnG')
		this.formContainer = card
		this.handleEvent = function (event) {
			this.eventDispatcher(event)
		}
		this.setButtons()
		this.setEventListener()
    this.tryLogin()
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

  toggleComponents() {
    let keys = Object.keys(this.state.components)

    for (let key of keys) {
      this.state.components[key].toggleLogin()
    }
  }

	callback (response, httpStatus) {
		if (response['flash']) {
			printNotif(response['flash'], httpStatus)
		}
		if (response.settings) {
			this.state.setLogin(response.settings)
			this.toggleLoginButton()
			this.state.components[this.name].shutDown()
      this.toggleComponents()
      if (this.redirect) {
			  let redirection = '#' + this.redirect

		    this.redirect = ''
			  window.location.assign(redirection)
      }
		}
	}

  toggleLogin() {
  }

  tryLogin() {
    let request = {
      method: "Get",
      url: "/user",
      body: {},
    }

	  ggAjax(request, this)
  }
}
