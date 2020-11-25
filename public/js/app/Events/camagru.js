import {Photographer} from '../Controller/photomaton/photographer.js'
import {Filters} from '../Controller/photomaton/filters.js'
import {MyPictures} from '../Controller/photomaton/mypictures.js'

export class Camagru {
		constructor(name) {
				this.name = name
				this.buttons = []
		}

		init() {
				this.canvas = document.getElementsByTagName("canvas")[0]
				this.canvas.width = 400
				this.canvas.height = 300

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
