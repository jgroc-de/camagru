import { ModalController } from './ModalController.js'
import { ggAjax } from '../../Library/ggAjax.js'
import { request } from './request.js'

export class FormModal extends ModalController {
	constructor (state, name, formName) {
		super(state, formName)
		this.name = name
		this.formContainer = document.getElementById(name)
		this.eventType = 'click'
		this.buttons = []
		this.handleEvent = function (event) {
			this.eventDispatcher(event)
		}
		this.setButtons()
		this.setEventListener()
	}

	eventDispatcher(event) {
		event.preventDefault()
		event.stopPropagation()

    switch(event.type) {
      case 'click':
        this.submit(event)
        break;
      default:
    }
  }

  setEventListener() {
    let i = 0

    while (i < this.buttons.length) {
      this.buttons[i++].addEventListener(this.eventType, this, false)
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
    let forms = this.card.getElementsByTagName('form')
    let i = 0

    while (i < forms.length) {
      this.addButtons(forms[i++])
    }
  }

  submit (event) {
    let inputs = event.target.form
		console.log("form event target: ")
		console.log(event.target)

    if (inputs.checkValidity()) {
      ggAjax(new request(inputs), this)
    } else {
      console.log("valid: "+ inputs.checkValidity())
    }
  }

	callback (response) {
		if (this.redirect && response['flash']) {
			printNotif(response['flash'], this.status)
		}
	}
}
