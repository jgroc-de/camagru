import { hiddenFormController } from '../Abstract/hiddenFormController.js'

export class Reinit extends hiddenFormController {
  constructor (state) {
    super(state, "reinit", "authForm")
  }

  callback (response) {
  }
}
