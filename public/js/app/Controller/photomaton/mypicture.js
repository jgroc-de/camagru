import {ggAjax} from '../../../Library/ggAjax.js'
import {printNotif} from '../../../Library/printnotif.js'
import {getImage} from '../../../Library/image.js'

export class MyPicture {
		constructor(section, data) {
				this.section = section
				this.data = data
				this.buildView(this.getView("myPicture"))
				this.setEvent()
		}

		setEvent() {
				let trash = this.section.getElementsByTagName("div")[1]

				this.handleEvent = function (event) {
						this.eventDispatcher(event)
				}
				trash.addEventListener("click", this, false)
		}

		getView(name) {
				let template = document.querySelector("#" + name + "_skeleton").content;

				return document.importNode(template, true).firstElementChild;
		}

		delete() {
				return {
						url: '/picture/' + this.data.id,
						method: "delete",
						body: {}
				}
		}

		eventDispatcher(event) {
				event.preventDefault()
				event.stopPropagation()

				ggAjax(this.delete(event), this)
		}

		buildView(tmpNode) {
				getImage(tmpNode.getElementsByTagName("img")[0], this.data)
				tmpNode.getElementsByTagName("span")[0].textContent = this.data.id
				tmpNode.getElementsByTagName("a")[0].href = "/#picture/" + this.data.id
				this.node = this.section.insertBefore(
						tmpNode,
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
