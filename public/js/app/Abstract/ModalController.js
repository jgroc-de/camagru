import { hiddenController } from './hiddenController.js'

export class ModalController extends hiddenController {
	constructor (state, name) {
		super(state, name)
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
		console.log(hash)

		for (let link of links) {
		console.log(link)
			if (link.hash === hash)
				link.classList.add("w3-grey")
			else
				link.classList.remove("w3-grey")
		}
	}

  view (defaultView = false) {
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
