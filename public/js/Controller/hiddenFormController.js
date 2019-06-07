import { hiddenController } from './hiddenController.js'
import { ggAjax } from '../Library/ggAjax.js'

export class hiddenFormController extends hiddenController {
  constructor (state, name) {
    super(state, name)
    this.logBtnG = document.getElementById('logBtnG')
    this.authForm = document.getElementById('form')
    this.section = document.getElementById(name)
    this.form = this.section.getElementsByTagName('form')[0]
    this.eventType = 'click'
    this.listener = this.submit
    this.button = this.setButton()
    this.data = {}
  }

  view (defaultView = false) {
    if (defaultView) {
      this.authForm.style.display = 'none'
    } else {
      if (this.state.isLogin()) {
        this.authForm.style.display = 'none'
        this.section.setAttribute('hidden', true)
      } else {
        this.authForm.style.display = 'block'
        this.section.removeAttribute('hidden')
      }
    }
  }

  submit (event) {
    let form = event.target.form
    let i = 0

    while (i < form.length) {

      if (form[i].name !== "") {
        this.data[form[i].name] = form[i].value
      }
      i++
    }

    ggAjax(JSON.stringify(this.data), form, this)
  }
}
