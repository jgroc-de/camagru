import { hiddenViewController } from './hiddenViewController.js'
import { request } from './request.js'
import { ggAjax } from '../../Library/ggAjax.js'

export class newPage extends hiddenViewController {
	constructor (state, name = '', components = [], view) {
		super(state)
		this.name = name
    this.template = view
		this.resetView(components)
		this.buildView()
		this.card = document.getElementById(this.name)
		this.section = this.card.getElementsByTagName('section')[0]
		this.link = this.card.children[0].children[0]
	}

	resetView (components) {
    for (let name of components) {
      console.log(name)
      if (this.state['components'][name]) {
        let card = this.state['components'][name].card

        card.parentNode.removeChild(card)
        delete this.state['components'][name]
      }
    }
    console.log("end reset")
  }

	buildView () {
		let anchor = document.getElementById('notif')
		let template = (new DOMParser()).parseFromString(this.template.template, 'text/html')

		anchor.parentNode.insertBefore(
			template.body.childNodes[0],
			anchor.nextElementSibling
		)

		return template
	}
}
