import { ggAjax } from '../../../../Library/ggAjax.js'
import { Picture } from './picture.js'
import * as view from '../../../View/picture.js'

export class PicturesManager {
	constructor (section) {
		this.section = section
		this.pictures = []
		this.max = 1
		this.page = 0
		this.getPictures()
		this.view = this.getView()
	}

	getView() {
		return (new DOMParser()).parseFromString(view.template, 'text/html')
	}

	getPictures(sort = 'Date', page = 0) {
		this.sortOption = sort

		let request = {
			method: "Get",
			url: "/picturesBy" + sort + "/" + page,
			body: {}
		}

		ggAjax(request, this)
	}

	setPictures (pictures) {
		let i = 0
		let node

		for (let picture of pictures) {
			node = this.view.cloneNode(true)
			this.pictures.push(new Picture(node, picture))
		}
	}

	destroyView() {
		let child

		while (child = this.section.firstChild) {
			this.section.removeChild(child)
		}
		this.pictures = []
	}

	buildView () {
		for (let picture of this.pictures) {
			this.section.appendChild(picture.node.cloneNode(true))
		}
	}

	callback (response) {
		if (response.max) {
			this.max = response.max
		}
		if (response.page) {
			this.page = response.page
		}
		if (response.pictures) {
			this.setPictures(response.pictures)
			this.buildView()
		}
	}
}
