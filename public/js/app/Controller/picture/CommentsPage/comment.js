import {ggAjax} from '../../../../Library/ggAjax.js'
import {printNotif} from '../../../../Library/printnotif.js'

export class Comment {
		constructor(section, data, state) {
				this.state = state
				this.section = section
				this.data = data
				this.buildView(this.getView("comment"), state)
		}

		setEvent(state) {
				if (state.isLogin() && state.login.id === this.data.author_id) {
						this.eventType = 'click'
						this.handleEvent = function (event) {
								this.eventDispatcher(event)
						}
						this.setEventListener()
				}
		}

		setNodeData(node) {
				node.getElementsByTagName("h3")[0].firstChild.data = this.data.pseudo + " "
				node.getElementsByTagName("span")[0].innerText = this.data.date
				node.getElementsByTagName("p")[0].innerText = this.data.content
		}

		getView(name) {
				let template = document.querySelector("#" + name + "_skeleton").content;

				return document.importNode(template, true).firstElementChild;
		}

		buildView(node, state) {
				this.setNodeData(node)
				this.node = this.section.insertBefore(
						node.body.childNodes[0],
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
								request = this.delete(event)
								break;
						case 'blur':
								request = this.update(event)
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

				i.classList.toggle("w3-hide")
				p.setAttribute("contenteditable", true)
				p.classList.toggle("gg-button")
				i.addEventListener("click", this, false)
				p.addEventListener("blur", this, false)
		}

		update(event) {
				let content = event.target.innerText

				if (this.content !== content) {
						this.content = content
						return {
								url: '/comment/' + this.data.id,
								method: "patch",
								body: {
										comment: content
								}
						}
				}
				return false
		}

		delete() {
				return {
						url: '/comment/' + this.data.id,
						method: "delete",
						body: {}
				}
		}

		updateComment(response) {
				if (response.status === 'deleted') {
						this.node.parentNode.removeChild(this.node)
				} else if (!response['flash']) {
						this.data = response
						this.setNodeData(this.node)
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

		remove() {
				this.node.parentNode.removeChild(this.node)
		}
}
