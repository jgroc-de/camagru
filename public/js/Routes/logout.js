import { ggAjax } from '../Library/ggAjax.js'

export class Logout {
  constructor (login) {
    this.button = document.getElementById('logBtnB')
    this.logBtnG = document.getElementById('logBtnG')
    this.settings = document.getElementById('btnSettings')
    this.logBtnB = this.button
    this.form = {
      method: 'delete',
      action: 'http://localhost:8080/login',
      checkValidity () { return true }
    }
    this.login = login
  }

  setData () {
  }

  sendData () {
    ggAjax('', this.form, this)
  }

  callback (response) {
    this.login.login()
    this.settings.toggleAttribute('hidden')
  }
}
