import { hiddenController } from './hiddenController.js'

export class Contact extends hiddenController {
  constructor (state) {
    super(state, "contact")
    this.form = this.section.getElementsByTagName('form')[0]
    this.eventType = 'click'
    this.listener = this.submit
    this.button = this.setButton()
  }
}
