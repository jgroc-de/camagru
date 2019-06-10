import { Controller } from  '../Abstract/controller.js'
import * as photo from '../View/camagru.js'

export class Camagru extends Controller {
	constructor (state, name) {
		super(state, name)
	}

	view(defaultView = false) {
		let anchor = document.getElementById('notif')
		let view = (new DOMParser()).parseFromString(photo.template, 'text/html')

		console.log(anchor)
		console.log(view)
		anchor.parentNode.insertBefore(
			view.body,
			anchor.nextElementSibling
		)

		return true
	}
}