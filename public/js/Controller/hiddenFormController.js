import { hiddenController } from './hiddenController.js'
import { ggAjax } from '../Library/ggAjax.js'

export class hiddenFormController extends hiddenController {
  constructor (state, name, formName = false) {
    super(state, name)
    if (formName) {
      this.formContainer = document.getElementById(formName)
    }
    this.eventType = 'click'
    this.buttons = []
    this.handleEvent = function ggEvent (event) {
      console.log(this.name)
      event.preventDefault()
      event.stopPropagation()

      switch(event.type) {
        case 'click':
          this.submit(event)
          break;
        default:
      }
    }
    this.setButtons()
    this.setEventListener()
  }

  setEventListener() {
    let j = 0

    while (j < this.buttons.length) {
      this.buttons[j++].addEventListener(this.eventType, this, false)
    }
  }

  view (defaultView = false) {
    if (defaultView) {
      this.formContainer.style.display = 'none'
    } else {
      let sections = this.formContainer.getElementsByTagName('section')
      let j = 0

      while (j < sections.length) {
        if (sections[j].id !== this.section.id) {
          sections[j].hidden = true
        } else {
          sections[j].removeAttribute('hidden')
        }
        j++
      }
      this.formContainer.style.display = 'block'
    }

    return true
  }

  setButtons () {
    let forms = this.section.getElementsByTagName('form')
    let i = 0

    while (i < forms.length) {
      let buttons = forms[i++].getElementsByTagName('button')

      for (let button of buttons) {
        if (button.type === 'submit') {
          this.buttons.push(button)
        }
      }
    }
  }

  submit (event) {
    let inputs = event.target.form
    let i = 0
    this.request.body = {}

    while (i < inputs.length) {

      if (inputs[i].name !== "") {
        this.request.body[inputs[i].name] = inputs[i].value
      }
      i++
    }
    this.request.url = inputs.action
    this.request.method = inputs.attributes ? inputs.attributes["method"].value : inputs.method
    console.log(this.request)

    if (inputs.checkValidity()) {
      ggAjax(this.request, this)
    } else {
      console.log(form.checkValidity())
    }
  }
}
