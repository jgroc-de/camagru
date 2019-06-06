import { ggAjax } from '../Library/ggAjax.js'

export class Contact {
  constructor () {
    this.section = document.getElementById('contact')
    this.form = this.section.getElementsByTagName('form')[0]
    this.link = this.section.children[0].children[0]
    this.data = {
      name: '',
      email: '',
      subject: '',
      message: ''
    }
    this.eventType = 'click'
    this.listener = this.submit
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

  submit (event) {
    let form = event.target.form
    let data = {}
    let i = 0

    event.preventDefault()
    event.stopPropagation()
    while (i < form.length) {

      if (form[i].name !== "") {
        data[form[i].name] = form[i].value
      }
      i++
    }

    ggAjax(JSON.stringify(data), form)
  }

  view () {
    let link = this.link.href.split("#").pop()

    this.section.children[1].toggleAttribute('hidden')
    if (link === "") {
      this.link.href = "#contact"
    } else {
      this.link.href = "#"
    }
  }
}
