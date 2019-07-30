import { ggAjax } from '../../../../Library/ggAjax.js'
import { request } from '../../../Abstract/request.js'
import { printNotif } from '../../../../Library/printnotif.js'

export class TitleManager {
	constructor(section, state) {
		this.section = section.getElementsByTagName("h2")[0]
    this.button = this.section.getElementsByTagName("i")[0]
    this.isLogin = state.isLogin()
    this.login = state.login
    this.picture_id = -1
    this.title = ""
    this.owner_id = 0
		this.eventType = 'click'
		this.handleEvent = function (event) {
			this.eventDispatcher(event)
		}
		this.setEventListener()
	}
  
  setTitle(title) {
    this.title = title
    this.section.firstChild.data = title
  }

  setOwner(id) {
    this.owner_id = id
    if (this.isLogin && this.login.id === this.owner_id) {
      this.button.classList.toggle("w3-hide")
    }
  }

  set(picture) {
    this.setTitle(picture.title)
    this.setOwner(picture.author_id)
    this.picture_id = picture.id
  }

	eventDispatcher(event) {
		event.preventDefault()
		event.stopPropagation()

    switch(event.type) {
      case 'click':
        this.submit(event)
        break;
      default:
    }
  }

  setEventListener() {
    this.section.lastChild.addEventListener(this.eventType, this, false)
  }

  submit (event) {
    let title = prompt("enter new title", "lol")

    if (title) {
      let inputs = {
        0:{
          name:"title",
          value:title,
        },
        action:'/picture/' + this.picture_id,
        method:'patch',
        length:1,
      }
      this.title = title
      ggAjax(new request(inputs), this)
    } else {
			printNotif('Title cant be empty', 400)
    }
  }

	callback (response, httpStatus) {
		if (response['flash']) {
			printNotif(response['flash'], httpStatus)
		}
		if (httpStatus === 200) {
			printNotif('Success', httpStatus)
      this.setTitle(response.title)
		}
  }
}
