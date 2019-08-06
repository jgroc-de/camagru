import { Controller } from '../../AnGGular/controller.js'
import { ModalView } from '../../AnGGular/Views/modal.js'
import { Events } from './Events/commonFormsEvents.js'

export class Signup extends Controller {
	constructor (state, name = "signup") {
		super({
      state: state,
      name: name,
      view: new ModalView(name, "authForm"),
      events: new Events(name),
    })
	}
}
