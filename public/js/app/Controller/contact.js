import { hiddenFormController } from '../Abstract/hiddenFormController.js'

export class Contact extends hiddenFormController {
  constructor (state) {
    super(state, "contact")
  }

  //dirty: duplicate of hiddenController
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
}
