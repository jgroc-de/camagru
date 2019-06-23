import { Controller } from '../Abstract/controller.js'

export class Burger extends Controller {
	constructor (state) {
		super(state, 'burger')
		this.link = document.getElementById(this.name)
		this.nav = document.getElementById('pageNav')
		this.hiddenBtns = [
			document.getElementById('btnSettings'),
			document.getElementById('btnPictures'),
		]
	}

	view(defaultView = false) {
		let link = this.link.href.split("#").pop()

		if (defaultView) {
			this.link.href = "#" + this.name
			this.nav.setAttribute('hidden', true)
		} else {
			this.nav.toggleAttribute('hidden')
			this.toggleHiddenButtons()
			if (link === this.name) {
				this.link.href = "#!" + this.name
			} else {
				this.link.href = "#" + this.name
			}
		}

		return false
	}

	toggleHiddenButtons () {
			if (this.state.isLogin()) {
				for (let btn of this.hiddenBtns) {
					btn.removeAttribute('hidden')
				}
			} else {
				for (let btn of this.hiddenBtns) {
					btn.setAttribute('hidden', '')
				}
			}
	}
}
