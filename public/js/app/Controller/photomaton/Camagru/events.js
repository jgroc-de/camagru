import { Photographer } from './photographer.js'
import { Filters } from './filters.js'
import { MyPictures } from './mypictures.js'

export class Events {
  constructor(name) {
    this.name = name
    this.buttons = []
  }

  init() {
		this.MyPictures = new MyPictures()
		this.Photographer = new Photographer(this.MyPictures)
		this.Filters = new Filters()
    this.setEvents()
  }

  setEvents() {
		this.card = document.getElementById(this.name)
		let sections = this.card.getElementsByTagName('section')

		this.handleEvent = function (event) {
			this.eventDispatcher(event)
		}
		this.buttons = sections[1].getElementsByTagName("button")
    
    this.buttons[0].addEventListener('click', this, false);
    this.buttons[1].addEventListener('click', this, false);
  }

  switchPage(page1, page2) {
    if (page1.hide()) {
      this.buttons[0].classList.toggle("w3-grey")
      this.buttons[1].classList.toggle("w3-grey")
      page2.show()
    }
  }

  submit(event) {
    switch (event.target.innerText) {
      case "filters":
        this.switchPage(this.MyPictures, this.Filters)
        break
      case "my pictures":
        this.switchPage(this.Filters, this.MyPictures)
        break
    }
  }

	eventDispatcher(event) {
		event.preventDefault()
    event.stopPropagation()
    
    this.submit(event)
  }
}
