import { ggAjax } from '../../../../Library/ggAjax.js'
import { Likes } from './likes.js'
import { Title } from './title.js'
import { printNotif } from '../../../../Library/printnotif.js'

export class PicturePage {
	constructor(section, state) {
    this.id = state.id
		this.section = section
		this.picture = null
    this.likes = new Likes(this.section, state)
    this.title = new Title(this.section, state)
		this.getPicture()
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

  setImage() {
    let img = this.section.getElementsByTagName("img")[0]
    
    img.src = this.picture.url
    img.alt = this.picture.title
  }

  setPicture() {
    this.title.set(this.picture)
    this.setAuthor()
    this.setImage()
    this.likes.set(this.picture)
  }

	callback (response, httpStatus) {
		if (httpStatus <= 400) {
      this.picture = response
		  this.setPicture()
		}
		if (response['flash']) {
			printNotif(response['flash'], httpStatus)
		}
	}
}

