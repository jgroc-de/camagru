import { hiddenFormController } from './hiddenFormController.js'

export class Login extends hiddenFormController {
  constructor (state) {
    super(state, "login")
    this.button.addEventListener(this.eventType, this, false)
  }

  callback (response, objet) {
    objet.logBtnG.href = '#logout'
    objet.logBtnG.className = "w3-bar-item w3-black w3-button"
    objet.state.setLogin(this.data.pseudo)
    this.data = {}
    window.location.assign('#')
  }
}
