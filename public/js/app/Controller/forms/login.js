import { Controller } from '../../AnGGular/controller.js'
import { ModalView } from '../../AnGGular/Views/modal.js'
import { LoginEvents as Events } from './Events/loginE.js'

export class Login extends Controller {
	constructor(state, name = "login") {
		super({
      state: state,
      name: name,
      view: new ModalView(name, "authForm"),
      events: new Events(name, state),
    })
	}
}
