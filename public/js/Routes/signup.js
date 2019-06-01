import { ggAjax } from '../Library/ggAjax.js'

export class SignUp {
  constructor () {
    this.section = document.getElementById('signup')
    this.form = this.section.getElementsByTagName('form')[0]
    this.data = {
      pseudo: '',
      password: '',
      email: ''
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
    this.data.email = this.form[2].value
  }

  sendData () {
    ggAjax(JSON.stringify(this.data), this.form)
  }
}
