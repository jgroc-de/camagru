import { newPage } from '../../Abstract/newPage.js'
import * as view from '../../View/pictures.js'
import { PicturesManager } from './Pictures/picturesManager.js'

export class Pictures extends newPage {
	constructor (state) {
		super(state, 'pictures', [
			'camagru'
    ], view)
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
}
