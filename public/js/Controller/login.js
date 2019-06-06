import { ggAjax } from '../Library/ggAjax.js'

export class Login {
  constructor (isLogin = false) {
    this.logBtnG = document.getElementById('logBtnG')
    this.logBtnB = document.getElementById('logBtnB')
    this.settings = document.getElementById('btnSettings')
    this.camagruBtn = document.getElementById('camagruBtn')
    this.isLogin = isLogin
    this.login(isLogin)
    this.section = document.getElementById('login')
    this.authForm = document.getElementById('form')
    this.closeBtn = document.getElementById('closeBtn')
    this.form = this.section.getElementsByTagName('form')[0]
    this.button = this.setButton()
    this.data = {
      pseudo: '',
      password: ''
    }
  }

  login (isLogin = false) {
    if (isLogin) {
      this.logBtnG.style.display = 'none'
      this.logBtnB.style.display = 'block'
      this.settings.toggleAttribute('hidden')
    } else {
      this.camagruBtn.addEventListener('click', this.loginPopIn)
      this.logBtnG.style.display = 'block'
      this.logBtnB.style.display = 'none'
    }
  }

  loginPopIn (event) {
    let logBtnG = document.getElementById('logBtnG')

    event.preventDefault()
    event.stopPropagation()
    logBtnG.click()
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

  callback (response = null) {
    this.logBtnG.style.display = 'none'
    this.logBtnB.style.display = 'block'
    this.closeBtn.click()
    this.settings.toggleAttribute('hidden')
    this.camagruBtn.removeEventListener('click', this.loginPopIn)
  }
}
