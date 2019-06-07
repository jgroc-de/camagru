import { ggAjax } from '../Library/ggAjax.js'

export class hiddenController {
  constructor (state, name) {
    this.state = state
    this.data = {}
    this.name = name
    this.section = document.getElementById(this.name)
    this.link = this.section.children[0].children[0]
    this.handleEvent = function test(event) {
      console.log(this.name);
      event.preventDefault()
      event.stopPropagation()

      switch(event.type) {
        case 'click':
          this.submit(event)
          break;
        default:
      }
    };

  }

  view(defaultView = false) {
    let link = this.link.href.split("#").pop()

    if (defaultView) {
        this.link.href = "#" + this.name
        this.section.children[1].setAttribute('hidden', true)
    } else {
      this.section.children[1].toggleAttribute('hidden')
      if (link === "") {
        this.link.href = "#" + this.name
      } else {
        this.link.href = "#"
      }
    }

    return false
  }

  wakeUp () {
    return this.view()
  }

  shutDown () {
    this.view(true)
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
    let i = 0

    event.preventDefault()
    event.stopPropagation()
    while (i < this.form.length) {

      if (this.form[i].name !== "") {
        this.data[this.form[i].name] = this.form[i].value
      }
      i++
    }

    if (this.form.checkValidity()) {
      ggAjax(JSON.stringify(this.data), this.form)
    } else {
      console.log(this.form.checkValidity())
    }
  }
}
