export class PictureView {
		constructor(name, state) {
				this.name = name
				this.state = state
				this.hide = true
		}

		init() {
		}

		run(test = true) {
				if (!this.picture) {
						this.picture = this.state.components.picture
				}
				if (test) {
				} else {
						if (!this.hide) {
								this.picture.events.reinit()
						}	else {
								this.hide = !this.hide
						}
				}
		}
}
