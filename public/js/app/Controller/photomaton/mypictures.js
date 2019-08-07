import { ggAjax } from '../../../Library/ggAjax.js'
import { MyPicture } from './mypicture.js'

export class MyPictures {
	constructor () {
    this.isHidden = true
	  this.section = document.getElementById("mypictures")
	}

  add(picture) {
    if (!this.firstLaunch()) {
      this.pictures.push(new MyPicture(this.section, picture))
    }
  }

  hide() {
    if (!this.isHidden) {
      this.section.classList.toggle("w3-hide")
      this.isHidden = true
      return true
    }
  }

  firstLaunch() {
    if (!this.pictures) {
      this.pictures = []
		  this.getPictures()
      return true
    }
  }

  show() {
    this.firstLaunch()
    if (this.isHidden) {
      this.isHidden = false
      this.section.classList.toggle("w3-hide")
      return true
    }
  }

	getPictures() {
		let request = {
			method: "Get",
			url: "/picturesByUser" ,
			body: {},
		}

		ggAjax(request, this)
	}

	setPictures(pictures) {
		let i = 0

		while (i < pictures.length) {
			this.pictures.push(new MyPicture(this.section, pictures[i]))
			i++
		}
	}

	callback(response) {
		if (response.pictures) {
			this.setPictures (response.pictures)
		}
	}
}
