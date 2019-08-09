import { ggAjax } from '../../../Library/ggAjax.js'
import { Filter } from './filter.js'

export class Filters {
	constructor () {
		this.filters = []
    this.screenNode = document.getElementById("montage")
		this.getFilters()
    this.isHidden = false
	  this.section = document.getElementById("filters")
    this.info = document.getElementById("info")
    this.toChange = false
	}

  hide() {
    if (!this.isHidden) {
      console.log(this.section.classList)
      if (!this.section.classList.contains("w3-hide")) {
        this.section.classList.add("w3-hide")
        this.toChange = true
      }
      this.info.classList.add("w3-hide")
      this.isHidden = true
      return true
    }
  }

  show() {
    if (this.isHidden) {
      this.isHidden = false
      this.info.classList.remove("w3-hide")
      if (this.section.classList.contains("w3-hide") && this.toChange) {
        this.toChange = false
        this.section.classList.remove("w3-hide")
      }
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
			this.filters.push(new Filter(this.section, filters[i], this.screenNode, this.info))
			i++
		}
	}

	callback(response) {
		if (response.filters) {
			this.setFilters (response.filters)
		}
	}
}
