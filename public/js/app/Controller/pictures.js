import { hiddenController } from  '../Abstract/hiddenController.js'
import * as pictures from '../View/pictures.js'
import { PicturesManager } from './Pictures/picturesManager.js'

export class Pictures extends hiddenController {
	constructor (state, name) {
		super(state, 'pictures')
		if (!this.card) {
			this.buildView()
			this.card = document.getElementById('pictures')
			this.link = this.card.children[0].children[0]
		}
		this.PicturesManager = new PicturesManager(this.section)
	}

	buildView () {
		let anchor = document.getElementById('notif')
		let view = (new DOMParser()).parseFromString(pictures.template, 'text/html')

		anchor.parentNode.insertBefore(
			view.body,
			anchor.nextElementSibling
		)

		return view
	}
}
