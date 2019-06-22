import { ggAjax } from '../../../Library/ggAjax.js'
//import { Picture } from './picture.js'

export class PicturesManager {
	constructor (section) {
		this.section = section
		this.pictures = []
		this.getPictures()
		console.log('pictures')
	}

	getPictures(sort = 'Date', page = 0) {
		let request = {
			method: "Get",
			url: "/picturesBy" + sort + "/" + page,
			body: {}
		}

		ggAjax(request, this)
	}

/*	addPicture (pictures, template, div) {
		let i = 0
		let node

		while (i < pictures.length) {
			node = template.cloneNode(true)
			this.pictures.push(new Picture(node, pictures[i]))
			div.insertBefore(this.pictures[i].node, template)
			i++
		}
	}*/

	setPictures (pictures) {
		let div = this.section.getElementsByClassName('gg-filter')[0]
		let template = div.children[0]

		this.addPicture(pictures, template, div)
		div.removeChild(template)
	}

	callback (response) {
		console.log(response)
		if (response.pictures) {
			//this.setPictures(response.pictures)
		}
	}
}

