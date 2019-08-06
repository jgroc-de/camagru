export class HiddenView {
  constructor (name) {
    this.name = name
  }

  init () {
		this.card = document.getElementById(this.name)
		this.link = this.card.children[0].children[0]
  }

	run() {
  }
}
