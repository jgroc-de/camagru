import { hiddenFormController } from './hiddenFormController.js'

export class Login extends hiddenFormController {
  constructor (state) {
    super(state, "login", "authForm")
    this.logBtnG = document.getElementById('logBtnG')
  }

  callback (response) {
    this.logBtnG.href = '#logout'
    this.logBtnG.className = "w3-bar-item w3-black w3-button"
    this.state.setLogin(this.request.pseudo)
    this.request = {}
    window.location.assign('#')
  }
}
