import { ggAjax } from '../../../../Library/ggAjax.js'
import { LikeManager } from './likeManager.js'
import { TitleManager } from './titleManager.js'
import { printNotif } from '../../../../Library/printnotif.js'

export class PictureManager {
	constructor(section, state) {
    this.id = this.setId(state.id)
		this.section = section
		this.picture = null
    this.likeManager = new LikeManager(this.section, state)
    this.titleManager = new TitleManager(this.section, state)
		this.getPicture()
	}

  setId(id) {
    if (isNaN(id) || id <= 1) {
      id = 1
    }

    return id
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
    this.titleManager.set(this.picture)
    this.setAuthor()
    this.setImage()
    this.likeManager.set(this.picture)
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

