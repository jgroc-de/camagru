import { request } from './request.js'
import { ggAjax } from '../../Library/ggAjax.js'
	
export class Form {
  constructor() {
		this.buttons = []
		this.handleEvent = function (event) {
			this.eventDispatcher(event)
		}
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

  addButtons(form) {
    let buttons = form.getElementsByTagName('button')

    for (let button of buttons) {
      if (button.type === 'submit') {
        this.buttons.push(button)
      }
    }
  }

  submit(event) {
    let inputs = event.target.form

    if (inputs.checkValidity()) {
      ggAjax(new request(inputs), this)
    } else {
      console.log("valid: "+ inputs.checkValidity())
    }
  }
}

