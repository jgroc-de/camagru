import { ggAjax } from '../../../../Library/ggAjax.js'
import { printNotif } from '../../../../Library/printnotif.js'
import { request } from '../../../../Library/request.js'
import { Comment } from './comment.js'

export class CommentsPage {
	constructor(section, state) {
    this.state = state
		this.section = section
    this.init()
		this.handleEvent = function (event) {
			this.eventDispatcher(event)
		}
		this.setEventListener()
	}

  init() {
    this.comments = []
    this.setId()
		this.getComments()
		this.commentsSection = document.getElementById("comments")
    this.commentsId = []
    this.form = this.section.getElementsByTagName("form")[0]
    this.form.action = "/comment/" + this.id
    this.timeId = window.setInterval(this.update, 12000, this)
  }

  setId() {
    if (isNaN(this.state.id) || this.state.id <= 1) {
      this.state.id = 1
    }

    this.id = this.state.id
  }

  update(commentsPage) {
    if (!commentsPage.state.components['Picture']) {
      window.clearInterval(commentsPage.timeId)
    } else {
      let request = {
        url:'/comment/' + commentsPage.id,
        method:'put',
        body:{}
      }

      ggAjax(request, commentsPage)
    }
  }

  submit(event) {
    let inputs = event.target.form

    if (inputs.checkValidity()) {
      ggAjax(new request(inputs), this)
    } else {
      console.log("valid: "+ inputs.checkValidity())
    }
  }

	eventDispatcher(event) {
		event.preventDefault()
		event.stopPropagation()

    if (!this.state.isLogin()) {
      this.state.components.Login.redirect = this.state.route
      this.state.httpCode = 403
      window.location.assign('#login')
    } else {
      this.submit(event)
    }
  }

  setEventListener() {
    this.form.getElementsByTagName("button")[0].addEventListener("click", this, false)
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
      if (!this.commentsId.includes(comment.id)) {
        this.addComment(comment)
      } else {
        this.comments[this.commentsId.indexOf(comment.id)].updateComment(comment)
      }
    }
  }

  addComment(comment) {
    console.log("here")
    let item = new Comment(this.commentsSection, comment, this.state)

    this.commentsId.push(item.id)
    this.comments.push(item)
  }

	callback (response, httpStatus) {
		if (httpStatus === 200) {
		  this.setComments(response)
		}
    else if (httpStatus === 201) {
		  this.addComment(response.comment)
		}
		if (response['flash']) {
			printNotif(response['flash'], httpStatus)
		}
	}

  renew(state) {
    for (let comment of this.comments) {
      comment.setEvent(state)
    }
  }

  reset() {
    while (this.comments.length) {
      this.comments.pop().remove()
    }
    window.clearInterval(this.timeId)
  }
}
