export class ModalView {
  constructor(name, modal) {
    this.name = name
    this.modal = modal
  }

  init() {
    this.card = document.getElementById(this.modal)
    this.link = this.card.children[0].children[0]
  }

  hideOtherSections () {
    let sections = this.card.getElementsByTagName('section')
    let i = 0

    while (i < sections.length) {
      if (sections[i].id !== this.name) {
        sections[i].setAttribute('hidden', '')
      } else {
        sections[i].removeAttribute('hidden')
      }
      i++
    }
  }

  toggleLinks() {
    let links = this.card.getElementsByTagName('a')
    let i = 0
    let hash = '#' + this.name

    for (let link of links) {
      if (link.hash === hash)
        link.classList.add("w3-grey")
      else
        link.classList.remove("w3-grey")
    }
  }

  run(defaultView = false) {
    if (defaultView) {
      this.card.style.display = 'none'
    } else {
      this.hideOtherSections()
      this.toggleLinks()
      this.card.style.display = 'block'
    }

    return true
  }
}
