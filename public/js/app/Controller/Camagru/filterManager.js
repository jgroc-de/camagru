import { ggAjax } from '../../../Library/ggAjax.js'
import { Filter } from './filter.js'

export class FilterManager {
	constructor (section) {
		this.section = section
		this.filters = []
		this.getFilters()
	}

	getFilters() {
		let request = {
			method: "Get",
			url: "/filter",
			body: {},
		}

		ggAjax(request, this)
	}

	addFilter (filters, template, div) {
		let i = 0
		let node

		while (i < filters.length) {
			node = template.cloneNode(true)
			this.filters.push(new Filter(node, filters[i]))
			div.insertBefore(this.filters[i].node, template)
			i++
		}
	}

	setFilters (filters) {
		let div = this.section.getElementsByClassName('gg-filter')[0]
		let template = div.children[0]

		this.addFilter(filters, template, div)
		div.removeChild(template)
	}

	callback (response) {
		if (response.filters) {
			this.setFilters (response.filters)
		}
	}
}
