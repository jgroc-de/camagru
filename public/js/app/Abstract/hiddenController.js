import { Controller } from  './controller.js'

export class hiddenController extends Controller {
	constructor (state, name = '') {
		super(state, name)
		if (name) {
			this.card = document.getElementById(this.name)
			this.link = this.card.children[0].children[0]
		}
	}

	view(defaultView = false) {
		let link = this.link.href.split("#").pop()

		if (defaultView) {
			this.link.href = "#" + this.name
			this.card.children[1].setAttribute('hidden', true)
		} else {
			this.card.children[1].toggleAttribute('hidden')
			if (link === "") {
				this.link.href = "#" + this.name
			} else {
				this.link.href = "#"
			}
    }

    return false
  }

  wakeUp () {
    return this.view()
  }

  shutDown () {
    this.view(true)
  }
}
