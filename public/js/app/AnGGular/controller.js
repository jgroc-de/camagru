export class Controller {
		constructor(init) {
				this.state = init.state
				this.name = init.name
				this.view = init.view
				this.events = init.events
				this.resetView(init.components)
				this.buildView(init.template)
				this.card = document.getElementById(this.name)
				if (this.view) {
						this.view.init(this.card)
				}
				if (this.events) {
						this.events.init(this.card)
				}
		}

		toggleLogin() {
				if (this.events) {
						this.events.toggleLogin()
				}
		}

		wakeUp() {
				let keys = Object.keys(this.state.components)

				for (let key of keys) {
						if (this.state.components[key].view) {
								this.state.components[key].view.run(true)
						}
				}
				if (this.view) {
						return this.view.run(false)
				}
		}

		shutDown() {
				if (this.view) {
						this.view.run(true)
				}
		}

		resetView(components) {
				if (components) {
						for (let name of components) {
								if (this.state['components'][name]) {
										let card = this.state['components'][name].card

										card.parentNode.removeChild(card)
										delete this.state['components'][name]
								}
						}
				}
		}

		buildView(content) {
				if (content) {
						let anchor = document.getElementById('notif')
						for (let node of content.children) {
								anchor.parentNode.insertBefore(node, anchor.nextElementSibling)
						}
				}
		}
}
