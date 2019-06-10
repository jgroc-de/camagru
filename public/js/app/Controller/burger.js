export class Burger {
	constructor (state) {
		this.state = state
		this.name = 'burger'
		this.link = document.getElementById(this.name)
		this.nav = document.getElementById('pageNav')
		this.settings = document.getElementById('btnSettings')
	}

	view(defaultView = false) {
		let link = this.link.href.split("#").pop()

		if (defaultView) {
			this.link.href = "#" + this.name
			this.nav.setAttribute('hidden', true)
		} else {
			this.nav.toggleAttribute('hidden')
			if (this.state.isLogin()) {
				this.settings.removeAttribute('hidden')
			} else {
				this.settings.setAttribute('hidden', '')
			}
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
		return this.view(true)
	}
}
