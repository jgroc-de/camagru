import { hiddenController } from  '../Abstract/hiddenController.js'
import * as pictures from '../View/pictures.js'
import { PicturesManager } from './Pictures/picturesManager.js'

export class Pictures extends hiddenController {
	constructor (state, name) {
		super(state, 'pictures')
		this.resetView()
		if (!this.card) {
			this.buildView()
			this.card = document.getElementById('pictures')
			this.link = this.card.children[0].children[0]
		}
		this.PicturesManager = new PicturesManager(this.card.getElementsByTagName('section')[0])
		this.sort = 'Date'
		this.page = this.PicturesManager.page
		this.max = this.PicturesManager.max
		this.handleEvent = function (event) {
			this.eventDispatcher(event)
		}
		this.setEvents()
	}

	setEvents () {
		this.setSortButtons()
		this.setPageButtons()
	}

	setSortButtons () {
		this.sortBtns = document.getElementById('sortBtn')

		for (let btn of this.sortBtns.children) {
			btn.addEventListener('click', this, false)
		}
	}

	setPageButtons () {
		this.pageBtns = document.getElementById('carrousselBtn')

		this.pageBtns.firstChild.addEventListener('click', this, false)
		this.pageBtns.lastChild.addEventListener('click', this, false)
	}

	togglePageButtons () {
		let btn
		let i = 0

		while (i < this.pageBtns.children.length) {
			btn = this.pageBtns.children[i]
			switch (i) {
				case 0:
					if (this.page > 0) {
						btn.removeAttribute('disabled')
					} else {
						btn.setAttribute('disabled', '')
					}
					break
				case 1:
					btn.innerText = this.page + 1
					break
				case this.sortBtns.children.length:
					if (this.page < this.max) {
						btn.removeAttribute('disabled')
					} else {
						btn.setAttribute('disabled', '')
					}
			}
			i++
		}
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

	changeView () {
		this.PicturesManager.destroyView()
		this.PicturesManager.getPictures(this.sort, this.page)
	}

	submit (event) {
		this.setParams(event.target)
		this.toggleSortButtons(event.target)
		this.togglePageButtons(event.target)
		this.changeView()
	}

	toggleSortButtons () {
		for (let btn of this.sortBtns.children) {
			if (btn.id === this.sort) {
				btn.setAttribute('disabled', '')
			} else {
				btn.removeAttribute('disabled')
			}
		}
	}

	setParams (node) {
		switch (node.id) {
			case 'Date':
				this.sort = 'Date'
				break
			case 'Like':
				this.sort = 'Like'
				break
			case 'next':
				this.page += 1
				break
			case 'previous':
				this.page -= 1
				break
			default:
				this.page = node.innerText
		}
	}

	eventDispatcher(event) {
		event.preventDefault()
		event.stopPropagation()

    switch(event.type) {
      case 'click':
        this.submit(event)
        break;
      default:
    }
  }

	resetView () {
		let components = [
			'Camagru'
		]

		for (let name of components) {
			this.remove(name)
		}
	}

	remove (name) {
		if (this.state['components'][name]) {
			let card = this.state['components'][name].card

			card.parentNode.removeChild(card)
			delete this.state['components'][name]
		}
	}
}
