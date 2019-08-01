import * as view from '../../../View/myPicture.js'
import { ggAjax } from '../../../../Library/ggAjax.js'
import { printNotif } from '../../../../Library/printnotif.js'

export class MyPicture {
	constructor (section, data) {
		this.section = section
		this.data = data
    this.buildView(view.template)
    this.setEvent()
	}

  setEvent() {
    let trash = this.section.getElementsByTagName("div")[1]

    this.handleEvent = function (event) {
      this.eventDispatcher(event)
    }
    trash.addEventListener("click", this, false)
  }

  delete() {
    return {
      url:'/picture/' + this.data.id,
      method:"delete",
      body:{}
    }
  }

	eventDispatcher(event) {
		event.preventDefault()
    event.stopPropagation()

    ggAjax(this.delete(event), this)
  }

  setNode(img) {
		img.src = this.data.url
		img.alt = this.data.title
		img.title = this.data.title
  }

	buildView (template) {
		let tmpNode = (new DOMParser()).parseFromString(template, 'text/html')

    this.setNode(tmpNode.getElementsByTagName("img")[0])
    tmpNode.getElementsByTagName("span")[0].textContent = this.data.id
    tmpNode.getElementsByTagName("a")[0].href = "/#picture/" + this.data.id
		this.node = this.section.insertBefore(
      tmpNode.body.firstElementChild,
      this.section.firstChild
    )
  }

  removeNode(response) {
    if (response.status === 'deleted') {
      this.node.parentNode.removeChild(this.node)
    }
  }
  
	callback(response, httpStatus) {
		if (response['flash']) {
			printNotif(response['flash'], httpStatus)
		}
    if (httpStatus < 400) {
      this.removeNode(response);
    }
  }
}
