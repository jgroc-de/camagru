import { ggAjax } from '../../../../Library/ggAjax.js'
import * as view from '../../../View/comment.js'
import { printNotif } from '../../../../Library/printnotif.js'

export class Comment {
	constructor(section, state, comment) {
		this.section = section
    this.setData(comment)
    this.buildView(view.template, state)
	}

  setEvent(state) {
    if (state.isLogin() && state.login.id === this.author_id) {
      this.eventType = 'click'
      this.handleEvent = function (event) {
        this.eventDispatcher(event)
      }
      this.setEventListener()
    } else {
      console.log("not yours")
    }
  }

  setData(comment) {
    this.id = comment.id
    this.img_id = comment.img_id
    this.author_id = comment.author_id
    this.author = comment.pseudo
    this.content = comment.content
    this.date = comment.date
  }

  setNode() {
    this.node.getElementsByTagName("h3")[0].firstChild.data = this.author + " "
    this.node.getElementsByTagName("span")[0].innerText = this.date
    this.node.getElementsByTagName("p")[0].innerText = this.content
  }

	buildView (template, state) {
		this.node = (new DOMParser()).parseFromString(template, 'text/html')

    this.setNode()
		this.node = this.section.insertBefore(
		  this.node.body.childNodes[0],
			this.section.firstChild
		)
    this.setEvent(state)
  }

	eventDispatcher(event) {
		event.preventDefault()
    event.stopPropagation()
    let request
      
    switch (event.type) {
      case 'click':
        request = this.click(event)
        break;
      case 'blur':
        request = this.blur(event)
        break;
      default:
    }

    if (request) {
      ggAjax(request, this)
    }
  }

  setEventListener() {
    let i = this.node.getElementsByTagName("i")[0]
    let p = this.node.getElementsByTagName("p")[0]

    i.addEventListener("click", this, false)
    i.classList.toggle("w3-hide")
    p.setAttribute("contenteditable", true)
    p.addEventListener("blur", this, false)
  }

  blur(event) {
    let content = event.target.innerText

    if (this.content !== content) {
      this.content = content
      return {
        url:'/comment/' + this.id,
        method:"patch",
        body:{
          comment:content
        }
      }
    }
    return false
  }

  click() {
    return {
      url:'/comment/' + this.id,
      method:"delete",
      body:{}
    }
  }

  update(comment) {
    this.content = comment.content
    this.date = comment.date
    this.setNode()
  }

  updateComment(response) {
    if (response.status === 'deleted') {
      this.node.parentNode.removeChild(this.node)
    }
  }
  
	callback(response, httpStatus) {
		if (response['flash']) {
			printNotif(response['flash'], httpStatus)
		}
    if (httpStatus < 400) {
      this.updateComment(response);
    }
  }
}
