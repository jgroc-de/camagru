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
      if (this.state.isLogin()) {
        this.authForm.style.display = 'none'
      } else {
        this.authForm.style.display = 'block'
      }
    }

    return true
  }

  submit (event) {
    let form = event.target.form
    let i = 0

    event.preventDefault()
    event.stopPropagation()
    while (i < form.length) {

      if (form[i].name !== "") {
        this.data[form[i].name] = form[i].value
      }
      i++
    }

    if (this.form.checkValidity()) {
      ggAjax(JSON.stringify(this.data), form, this)
    } else {
      console.log(this.form.checkValidity())
    }
  }
}
