import { hiddenFormController } from './hiddenFormController.js'

export class Signup extends hiddenFormController {
  constructor (state) {
    super(state, 'signup')
    this.button.addEventListener(this.eventType, this, false)
  }

  callback (response, objet) {
  }
}