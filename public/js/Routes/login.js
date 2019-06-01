import { ggAjax } from '../Library/ggAjax.js'

export class LoginRoute {
  constructor () {
    this.logBtnG = document.getElementById('logBtnG')
    this.logBtnB = document.getElementById('logBtnB')
    this.section = document.getElementById('login')
    this.form = this.section.getElementsByTagName('form')[0]
    this.data = {
      pseudo: '',
      password: ''
    }
    this.button = this.setButton()
  }

  setButton () {
    let buttons = this.form.getElementsByTagName('button')

    for (let button of buttons) {
      if (button.type === 'submit') {
        return button
      }
    }
  }

  setData () {
    this.data.pseudo = this.form[0].value
    this.data.password = this.form[1].value
  }

  sendData () {
    ggAjax(JSON.stringify(this.data), this.form, this)
  }

  callback (response) {
    this.logBtnG.toggleAttribute('hidden')
    this.logBtnB.toggleAttribute('hidden')
  }
}
