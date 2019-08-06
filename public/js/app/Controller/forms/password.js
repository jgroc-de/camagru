import { Controller } from '../../AnGGular/controller.js'
import { ModalView } from '../../AnGGular/Views/modal.js'
import { Events } from './Events/commonFormsEvents.js'

export class Password extends Controller {
	constructor (state, name = "password") {
		super({
      state: state,
      name: name,
      view: new ModalView(name, "settingsForm"),
      events: new Events(name),
    })
		this.setFormsMethod()
	}

	setFormsMethod() {
		let forms = this.formContainer.getElementsByTagName('form')

		forms[0].method = "patch"
	}
}
