import {ggAjax} from '../../../../Library/ggAjax.js'
import {request} from '../../../../Library/request.js'
import {printNotif} from '../../../../Library/printnotif.js'

export class Likes {
		constructor(section, state) {
				this.state = state
				this.section = section.getElementsByTagName("h3")[0]
				this.picture_id = -1
				this.init()
				this.handleEvent = function (event) {
						this.eventDispatcher(event)
				}
				this.setEventListener()
		}

		init() {
				if (this.state.isLogin()) {
						this.user_id = this.state.login.id
				}
				this.count = 0
		}

		eventDispatcher(event) {
				event.preventDefault()
				event.stopPropagation()

				if (!this.state.isLogin()) {
						this.state.components.login.redirect = this.state.prevRoute
						window.location.assign('#login')
				} else {
						this.submit(event)
				}
		}

		setEventListener() {
				let i = this.section.getElementsByTagName("i");

				i[0].addEventListener("click", this, false)
				i[1].addEventListener("click", this, false)
		}

		submit(event) {
				let method = "post"
				if (event.target.title === "dislike") {
						method = "delete"
				}
				let inputs = {
						action: '/like/' + this.picture_id,
						method: method,
						length: 0,
				}

				ggAjax(new request(inputs), this)
		}

		setCount() {
				this.section.childNodes[1].textContent = this.count
		}

		set(picture) {
				this.picture_id = picture.id
				this.update(this)
				this.timeId = window.setInterval(this.update, 30000, this)
		}

		updateCount(count) {
				this.count = count
				this.setCount()
		}

		update(likes) {
				if (!likes.state.components['picture']) {
						window.clearInterval(likes.timeId)
				} else {
						let inputs = {
								action: '/like/' + likes.picture_id,
								method: 'get',
								length: 0,
						}

						ggAjax(new request(inputs), likes)
				}
		}

		callback(response, httpStatus) {
				if (response['flash']) {
						printNotif(response['flash'], httpStatus)
				}
				if (httpStatus < 400) {
						this.updateCount(response.count);
				}
		}

		reset() {
				window.clearInterval(this.timeId)
				this.init()
		}
}
