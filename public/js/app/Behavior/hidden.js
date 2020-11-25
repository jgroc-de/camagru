export class HiddenView {
		constructor(name) {
				this.name = name
		}

		init() {
				this.card = document.getElementById(this.name)
				this.link = this.card.children[0].children[0]
				//console.log("view hidden " + this.name)
		}

		run() {
		}
}
