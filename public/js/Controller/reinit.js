import { hiddenFormController } from './hiddenFormController.js'

export class Reinit extends hiddenFormController {
  constructor (state) {
    super(state, "reinit")
    console.log(this)
    this.button.addEventListener(this.eventType, this, false)
  }

  callback (response, objet) {
    window.location.assign('#')
  }
}

