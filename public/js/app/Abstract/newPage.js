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
    this.link = this.card.children[0].children[0]
	}

	resetView (components) {
    for (let name of components) {
      if (this.state['components'][name]) {
        let card = this.state['components'][name].card

        card.parentNode.removeChild(card)
        delete this.state['components'][name]
      }
    }
  }

  wakeUp () {
		for (let i in this.state.components) {
			this.state.components[i].shutDown()
		}

    return this.view(false)
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
