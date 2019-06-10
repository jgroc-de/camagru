import { Controller } from  '../Abstract/controller.js'

export class Index extends Controller {
	constructor (state, name) {
		super(state, name)
	}

	wakeUp () {
		for (let i in this.state.components) {
			this.state.components[i].shutDown()
		}
	}

	shutDown () {
	}
}
