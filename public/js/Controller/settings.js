import { hiddenFormController } from './hiddenFormController.js'

export class Settings extends hiddenFormController {
  constructor (state) {
    super(state, "settings", "settingsForm")
  }

  callback (response, objet) {
  }
}
