import { ggAjax } from '../../Library/ggAjax.js'
import { printNotif } from '../../Library/printnotif.js'
import { request } from '../Abstract/request.js'

export class Events {
  constructor() {
		this.buttons = []
  }

  toggleLogin() {
    //pourrait etre rempli
  }

  init(card) {
    this.card = card
		this.handleEvent = function (event) {
      console.log(event.target)
			this.eventDispatcher(event)
		}

		this.setButtons()
		this.setEventListener()
  }

  setButtons () {
    let form = this.card.getElementsByTagName('form')[0]
    let button = form.getElementsByTagName('button')[0]

    this.buttons.push(button)
  }

	eventDispatcher(event) {
    event.preventDefault()
    event.stopPropagation()

    switch(event.target.tagName) {
      case 'A':
        this.toggleHide(event)
        break;
      default:
        this.submit(event)
    }
  }

  toggleHide(event) {
    this.card.children[1].classList.toggle("w3-hide")
  }

  setEventListener() {
    let i = 0

    while (i < this.buttons.length) {
      this.buttons[i++].addEventListener("click", this, false)
    }
    let a = this.card.getElementsByTagName("a")[0]

    a.addEventListener("click", this, false)
  }

  submit (event) {
    let inputs = event.target.form

    if (inputs.checkValidity()) {
      ggAjax(new request(inputs), this)
    } else {
      console.log("valid: ")
      console.log(inputs.checkValidity())
    }
  }

	callback (response, httpStatus) {
		if (response['flash']) {
			printNotif(response['flash'], httpStatus)
		}
	}
}
