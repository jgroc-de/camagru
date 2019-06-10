import { hiddenViewController } from  '../Abstract/hiddenViewController.js'
import { ggAjax } from '../../Library/ggAjax.js'
import * as photo from '../View/camagru.js'
import { Filter } from './Camagru/filter.js'

export class Camagru extends hiddenViewController {
	constructor (state) {
		super(state)
		this.name = 'camagru'
		this.buildView()
		this.card = document.getElementById(this.name)
		this.section = this.card.getElementsByTagName('section')[0]
		this.link = this.card.children[0].children[0]
		console.log(this.link)
		this.filters = []
		this.getFilters()

		/*
		if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
		{
			navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream)
				{
					let video = document.getElementById('video');
					let button = document.getElementById('snap');
					snap(button);
					video.srcObject = stream;
					video.play();
				});
		}
		*/
	}

	getFilters() {
		let request = {
			method: "Get",
			url: "/filter",
			body: {},
    }

    ggAjax(request, this)
  }

	snap (button) {
		alert('lol');
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
		console.log(response)
		if (response.filters) {
			this.setFilters (response.filters)
		}
	}
}
