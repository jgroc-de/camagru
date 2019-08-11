export class About {
  constructor() {
  }

  init(card) {
    let a = card.getElementsByTagName("a")[0]
    this.p = card.children[1]

		this.handleEvent = function (event) {
			this.eventDispatcher(event)
		}

    a.addEventListener("click", this, false)
  }

	eventDispatcher(event) {
    event.preventDefault()
    event.stopPropagation()

    this.toggleHide()
  }

  toggleHide() {
    this.p.classList.toggle("w3-hide")
  }

  toggleLogin() {
  }
}
