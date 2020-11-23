import { ggAjax } from '../../../../Library/ggAjax.js'
import { Likes } from './likes.js'
import { Title } from './title.js'
import { printNotif } from '../../../../Library/printnotif.js'
import { getImage } from '../../../../Library/image.js'

export class PicturePage {
	constructor(section, state) {
    this.state = state
		this.section = section
    this.init()
    this.likes = new Likes(this.section, this.state)
    this.title = new Title(this.section, this.state)
	}

  init() {
		this.picture = null
    this.setId()
		this.getPicture()
  }

  setId() {
    if (isNaN(this.state.id) || this.state.id <= 1) {
      this.state.id = 1
    }

    this.id = this.state.id
  }

	getPicture() {
		let request = {
			method: "Get",
			url: "/picture/" + this.id,
			body: {}
		}

		ggAjax(request, this)
	}

  setAuthor() {
    let span = this.section.getElementsByTagName("span")[0]

    span.innerText = "by " + this.picture.pseudo + " on " + this.picture.date
  }

  setPicture(response) {
    this.picture = response
    this.title.set(this.picture)
    this.setAuthor()
    getImage(this.section.getElementsByTagName("img")[0], this.picture)
    this.likes.set(this.picture)
  }

	callback (response, httpStatus) {
		if (httpStatus <= 400) {
		  this.setPicture(response)
		}
		if (response['flash']) {
			printNotif(response['flash'], httpStatus)
		}
	}

  reset() {
    this.likes.reset()
    this.init()
  }
}

