export class Controller {
	constructor (state, name) {
		this.state = state
		this.name = name
	}

	view(defaultView = false) {
		return true
	}

	wakeUp () {
		return this.view()
	}

	shutDown () {
		this.view(true)
	}
}
