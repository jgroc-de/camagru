import { hiddenController } from './hiddenController.js'
import { ggAjax } from '../Library/ggAjax.js'

export class hiddenFormController extends hiddenController {
  constructor (state, name, formName = false) {
    super(state, name)
    if (formName) {
      this.authForm = document.getElementById(formName)
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
      this.authForm.style.display = 'none'
    } else {
      let sections = this.authForm.getElementsByTagName('section')
      let j = 0

      while (j < sections.length) {
        if (sections[j].id !== this.section.id) {
          sections[j].hidden = true
        } else {
          sections[j].removeAttribute('hidden')
        }
        j++
      }
      this.authForm.style.display = 'block'
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
    let form = event.target.form
    let i = 0

    while (i < form.length) {

      if (form[i].name !== "") {
        this.request[form[i].name] = form[i].value
      }
      i++
    }

    if (form.checkValidity()) {
      ggAjax(JSON.stringify(this.request), form, this)
    } else {
      console.log(form.checkValidity())
    }
  }
}
