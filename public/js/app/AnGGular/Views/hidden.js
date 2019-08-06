export class HiddenView {
  constructor (name) {
    this.name = name
  }

  init () {
		this.card = document.getElementById(this.name)
		this.link = this.card.children[0].children[0]
  }

	run(defaultView = false) {
    let href = this.link.href

    if (href) {
      let link = href.split("#").pop()

      if (defaultView) {
        this.link.href = "#" + this.name
        this.card.children[1].setAttribute('hidden', true)
      } else {
        this.card.children[1].toggleAttribute('hidden')
        if (link === this.name) {
          this.link.href = "#!" + this.name
        } else {
          this.link.href = "#" + this.name
        }
      }
    }

    return false
  }
}
