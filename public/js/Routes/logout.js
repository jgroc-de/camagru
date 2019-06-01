import { ggAjax } from '../Library/ggAjax.js'

export class LogoutRoute {
  constructor () {
    this.button = document.getElementById('logBtnB')
    this.logBtnG = document.getElementById('logBtnG')
    this.logBtnB = this.button
    this.form = {
      method: 'delete',
      action: 'http://localhost:8080/login',
      checkValidity () { return true }
    }
  }

  setData () {
  }

  sendData () {
    ggAjax('', this.form, this)
  }

  callback (response) {
    this.logBtnG.toggleAttribute('hidden')
    this.logBtnB.toggleAttribute('hidden')
  }
}
