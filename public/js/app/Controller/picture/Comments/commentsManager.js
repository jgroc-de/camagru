import { ggAjax } from '../../../../Library/ggAjax.js'
import { printNotif } from '../../../../Library/printnotif.js'
import { Comment } from './comment.js'

export class CommentsManager {
	constructor(section, state) {
    this.id = this.setId(state.id)
		this.section = section
		this.picture = null
    this.comments = []
    console.log(this.comments)
		this.getComments()
	}

  setId(id) {
    if (isNaN(id) || id <= 1) {
      id = 1
    }

    return id
  }

	getComments() {
		let request = {
			method: "Get",
			url: "/comment/" + this.id,
			body: {}
		}

		ggAjax(request, this)
	}

  setComments(response) {
    for (let comment of response.comments) {
      this.comments.add(new Comment(this.section, state))
    }
  }

	callback (response, httpStatus) {
		if (httpStatus <= 400) {
		  this.setComments(response)
		}
		if (response['flash']) {
			printNotif(response['flash'], httpStatus)
		}
	}
}

