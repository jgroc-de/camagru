import { hiddenController } from './hiddenController.js'
import { request } from './request.js'
import { ggAjax } from '../../Library/ggAjax.js'

export class hiddenFormController extends hiddenController {
	constructor (state, name, formName = false) {
		super(state, name)
		if (formName) {
			this.formContainer = document.getElementById(formName)
		}
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

  hideOtherSections () {
    let sections = this.formContainer.getElementsByTagName('section')
    let i = 0

    while (i < sections.length) {
      if (sections[i].id !== this.section.id) {
        sections[i].setAttribute('hidden', '')
      } else {
        sections[i].removeAttribute('hidden')
      }
      i++
    }
  }

  view (defaultView = false) {
    if (defaultView) {
      this.formContainer.style.display = 'none'
    } else {
      this.hideOtherSections()
      this.formContainer.style.display = 'block'
    }

    return true
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
    let forms = this.section.getElementsByTagName('form')
    let i = 0

    while (i < forms.length) {
      this.addButtons(forms[i++])
    }
  }

  submit (event) {
    let inputs = event.target.form

    if (inputs.checkValidity()) {
      ggAjax(new request(inputs), this)
    } else {
      console.log("valid: "+ inputs.checkValidity())
    }
  }
}
