import { ggAjax } from '../Library/ggAjax.js'

export class hiddenController {
  constructor (state, name) {
    this.state = state
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
}
