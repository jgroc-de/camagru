import { ggAjax } from '../../../../Library/ggAjax.js'
import { Filter } from './filter.js'

export class Filters {
	constructor () {
		this.filters = []
    this.screenNode = document.getElementById("montage")
		this.getFilters()
    this.isHidden = false
	  this.section = document.getElementById("filters")
	}

  hide() {
    if (!this.isHidden) {
      this.section.classList.toggle("w3-hide")
      this.isHidden = true
      return true
    }
  }

  show() {
    if (this.isHidden) {
      this.isHidden = false
      this.section.classList.toggle("w3-hide")
      return true
    }
  }

	getFilters() {
		let request = {
			method: "Get",
			url: "/filter",
			body: {},
		}

		ggAjax(request, this)
	}

	setFilters(filters) {
		let i = 0

		while (i < filters.length) {
			this.filters.push(new Filter(this.section, filters[i], this.screenNode))
			i++
		}
	}

	callback(response) {
		if (response.filters) {
			this.setFilters (response.filters)
		}
	}
}
