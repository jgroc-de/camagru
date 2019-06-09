import { hiddenFormController } from '../Abstract/hiddenFormController.js'

export class Signup extends hiddenFormController {
  constructor (state) {
    super(state, 'signup', "authForm")
  }

  callback (response, objet) {
  }
}
