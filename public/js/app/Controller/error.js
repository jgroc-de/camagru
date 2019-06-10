import { Controller } from  '../Abstract/controller.js'

export class Error extends Controller {
	constructor (state, name) {
		super(state, name)
	}

	wakeUp () {
		alert("lol")
	}

	shutDown () {
	}
}
