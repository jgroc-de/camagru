import { ggAjax } from '../../../../Library/ggAjax.js'
import { printNotif } from '../../../../Library/printnotif.js'
import { request } from '../../../Abstract/request.js'
import { Comment } from './comment.js'

export class CommentsPage {
	constructor(section, state) {
    this.id = this.setId(state.id)
    this.lastId = 0
    this.state = state
		this.section = section
		this.commentsSection = document.getElementById("comments")
    this.commentsId = []
    this.comments = []
		this.picture = null
		this.getComments()
		this.eventType = 'click'
		this.handleEvent = function (event) {
			this.eventDispatcher(event)
		}
		this.setEventListener()
    console.log(' ---- comments')
    this.timeId = window.setInterval(this.update, 12000, this)
	}

  setId(id) {
    if (isNaN(id) || id <= 1) {
      id = 1
    }

    return id
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
    let form = this.section.getElementsByTagName("form")[0]

    form.action += "/" + this.id
    form.getElementsByTagName("button")[0].addEventListener(this.eventType, this, false)
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
        this.commentsId.push(comment.id)
        this.comments.push(this.addComment(comment))
      } else {
        this.comments[this.commentsId.indexOf(comment.id)].updateComment(comment)
      }
    }
  }

  addComment(comment) {
    return new Comment(this.commentsSection, comment, this.state)
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
}
