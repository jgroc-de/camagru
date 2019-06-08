import { hiddenFormController } from './hiddenFormController.js'
import { ggAjax } from '../Library/ggAjax.js'

export class Settings extends hiddenFormController {
  constructor (state) {
    super(state, "settings", "settingsForm")
    this.getUser()
    this.setFormsMethod()
  }

  setFormsMethod() {
    let forms = this.formContainer.getElementsByTagName('form')

    forms[0].method = "patch"
    forms[1].method = "patch"
  }

  getUser() {
    let form = {
      method: "Get",
      url: "/user",
      body: {},
    }
    ggAjax(form, this)
  }

  callback (response) {
    if (!response.settings) {
      return
    }
    let form = this.section.children[1]
    let i = 0
    let name

      console.log(form)
    while (i < form.length) {
      name = form[i].name
      if (response.settings[name]) {
        console.log(name)
        if (name === "alert") {
          console.log(response.settings.alert)
          if (response.settings.alert) {
            form[i].setAttribute('checked', '')
          } else {
            form[i].removeAttribute('checked')
          }
        } else {
          form[i].value = response.settings[name]
        }
      }
      i++
    }
  }
}
