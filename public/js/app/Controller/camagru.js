import { hiddenViewController } from  '../Abstract/hiddenViewController.js'
import { ggAjax } from '../../Library/ggAjax.js'
import * as view from '../View/camagru.js'
import { Photographer } from './Camagru/photographer.js'
import { FilterManager } from './Camagru/filterManager.js'

export class Camagru extends hiddenViewController {
	constructor (state) {
		super(state)
		this.name = 'camagru'
		this.resetView()
		this.buildView()
		this.card = document.getElementById(this.name)
		this.section = this.card.getElementsByTagName('section')[0]
		this.link = this.card.children[0].children[0]
		this.FilterManager = new FilterManager(this.section)
		this.Photographer = new Photographer()
	}

	buildView () {
		let anchor = document.getElementById('notif')
		let template = (new DOMParser()).parseFromString(view.template, 'text/html')

		anchor.parentNode.insertBefore(
			template.body,
			anchor.nextElementSibling
		)

		return template
	}

	resetView () {
		let components = [
			'Pictures'
		]

		for (let name of components) {
			this.remove(name)
		}
	}

	remove (name) {
		if (this.state['components'][name]) {
			let card = this.state['components'][name].card

			card.parentNode.removeChild(card)
			delete this.state['components'][name]
		}
	}
}
