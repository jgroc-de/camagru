export class BurgerView {
  constructor(name, state) {
    this.state = state
    this.name = name
    this.hide = true
  }

  init(card) {
		this.nav = document.getElementById('pageNav')
    this.link = card
		this.hiddenBtns = [
			document.getElementById('btnSettings'),
			document.getElementById('btnPictures'),
			document.getElementById('btnMyPictures'),
		]
  }

	run(defaultView = false) {
		if (defaultView && !this.hide) {
      this.hide = !this.hide
			this.link.href = "#" + this.name
			this.nav.setAttribute('hidden', true)
		} else if (!defaultView) {
      this.hide = !this.hide
      let route = "#"

      if (this.state.prevRoute) {
        route += this.state.prevRoute
      }
      this.link.href = route
			this.nav.toggleAttribute('hidden')
			this.toggleHiddenButtons()
		}

		return false
	}

	toggleHiddenButtons() {
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
