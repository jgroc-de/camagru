import { Controller } from '../../Abstract/controller.js'
import * as pictures from '../../View/pictures.js'

export class Index extends Controller {
	constructor (state, name) {
		super(state, name)
	}

	wakeUp () {
		for (let i in this.state.components) {
			let component = this.state.components[i]

			component.shutDown()
		}
	}

	shutDown () {
	}
}
