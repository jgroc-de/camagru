import { PicturesManager } from '../Controller/pictures/picturesManager.js'

export class Events {
  constructor() {
    //console.log("events " + "pictures")
  }

  init(card) {
		this.card = card
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
    this.setSectionButton()
  }

  setSectionButton() {
    let a = this.card.getElementsByTagName("a")[0]

    a.addEventListener("click", this, false)
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

  toggleHide() {
    this.card.children[1].classList.toggle("w3-hide")
  }

  eventDispatcher(event) {
    event.preventDefault()
    event.stopPropagation()

    switch(event.target.tagName) {
      case 'A':
        this.toggleHide()
        break;
      default:
        this.submit(event)
    }
  }

  toggleLogin() {
  }
}
