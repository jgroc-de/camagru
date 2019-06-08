import { hiddenFormController } from './hiddenFormController.js'

export class Reinit extends hiddenFormController {
  constructor (state) {
    super(state, "reinit", "authForm")
    this.button.addEventListener(this.eventType, this, false)
  }

  callback (response, objet) {
  }
}

