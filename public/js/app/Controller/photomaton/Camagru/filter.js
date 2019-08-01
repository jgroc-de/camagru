import * as view from '../../../View/filter.js'

export class Filter {
	constructor (section, data) {
		this.section = section
		this.data = data
    this.buildView(view.template)
	}

  setNode(img) {

		img.src = this.data.url
		img.alt = this.data.title
		img.title = this.data.title
  }

	buildView (template) {
		let tmpNode = (new DOMParser()).parseFromString(template, 'text/html')

    this.setNode(tmpNode.getElementsByTagName("img")[0])
		this.node = this.section.appendChild(tmpNode.body.childNodes[0])
  }
}
