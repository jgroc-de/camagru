import { hiddenViewController } from  '../Abstract/hiddenViewController.js'
import { ggAjax } from '../../Library/ggAjax.js'
import * as photo from '../View/camagru.js'
import { Photographer } from './Camagru/photographer.js'
import { FilterManager } from './Camagru/filterManager.js'

export class Camagru extends hiddenViewController {
	constructor (state) {
		super(state)
		this.name = 'camagru'
		this.buildView()
		this.card = document.getElementById(this.name)
		this.section = this.card.getElementsByTagName('section')[0]
		this.link = this.card.children[0].children[0]
		this.FilterManager = new FilterManager(this.section)
		this.Photographer = new Photographer()
	}

	buildView () {
		let anchor = document.getElementById('notif')
		let view = (new DOMParser()).parseFromString(photo.template, 'text/html')

		anchor.parentNode.insertBefore(
			view.body,
			anchor.nextElementSibling
		)

		return view
	}
}
