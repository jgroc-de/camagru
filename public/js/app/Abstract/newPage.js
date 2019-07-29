import { hiddenViewController } from './hiddenViewController.js'
import { request } from './request.js'
import { ggAjax } from '../../Library/ggAjax.js'

export class newPage extends hiddenViewController {
	constructor (state, name = '', components = [], view) {
		super(state)
    this.template = view
		this.name = 'camagru'
		this.resetView(components)
		this.buildView()
    console.log(this.name)
		this.card = document.getElementById(this.name)
		this.section = this.card.getElementsByTagName('section')[0]
		this.link = this.card.children[0].children[0]
	}

	remove (name) {
		if (this.state['components'][name]) {
	    let card = this.state['components'][name].card
		  card.parentNode.removeChild(card)
			delete this.state['components'][name]
		}
	}

	resetView (components) {
		for (let name of components) {
      let tmp = document.getElementById(name)
      if (tmp) {
		    tmp.parentNode.removeChild(tmp)
      }
			this.remove(name)
		}
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
