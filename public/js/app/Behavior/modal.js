export class ModalView {
  constructor(name, params) {
    this.name = name
    this.state = params.state
    this.modal = params.modal
  }

  init() {
    this.card = document.getElementById(this.modal)
    this.sections = this.card.getElementsByTagName('section')
    this.links = this.card.getElementsByTagName('a')
    this.closeBtns = this.links[0]
    this.setCloseButtons()
  }

  setCloseButtons() {
    this.closeBtns.href = this.state.prevRoute
  }

  hideOtherSections () {
    let i = 0

    while (i < this.sections.length) {
      if (this.sections[i].id !== this.name) {
        this.sections[i].setAttribute('hidden', '')
      } else {
        this.sections[i].removeAttribute('hidden')
      }
      i++
    }
  }

  toggleLinks() {
    //i = 1 dont take the close buttons
    let i = 1
    let hash = '#' + this.name

    while (i < this.links.length) {
      if (this.links[i].hash === hash)
        this.links[i].classList.add("w3-grey")
      else
        this.links[i].classList.remove("w3-grey")
      i++
    }
  }

  run(defaultView = false) {
    if (defaultView) {
      this.card.style.display = 'none'
    } else {
      this.setCloseButtons()
      this.hideOtherSections()
      this.toggleLinks()
      this.card.style.display = 'block'
    }

    return true
  }
}
