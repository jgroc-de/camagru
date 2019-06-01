import { ggAjax } from '../Library/ggAjax.js'

export class Contact {
  constructor () {
    this.section = document.getElementById('contact')
    this.form = this.section.getElementsByTagName('form')[0]
    this.data = {
      name: '',
      email: '',
      subject: '',
      message: ''
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
    let i = 0
    let key

    for (key of Object.keys(this.data)) {
      this.data[key] = this.form[i++].value
    }
  }

  sendData () {
    ggAjax(JSON.stringify(this.data), this.form)
  }
}
