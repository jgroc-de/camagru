import {CommonForm} from "./commonForm.js"

export class Password extends CommonForm {
		constructor(name) {
				super(name)
		}

		extra() {
				this.setFormsMethod()
		}

		setFormsMethod() {
				let forms = this.formContainer.getElementsByTagName('form')

				forms[0].method = "delete"
		}

		submit(event) {
				let inputs = event.target.form

				if (confirm("You are going all your datas (image, comments, likes, etc…). This can not undo this operation. Any last words?")) {
						ggAjax(new request(inputs), this)
				}
		}

		callback(response, httpStatus) {
				if (response['flash']) {
						printNotif(response['flash'], httpStatus)
				}
				setTimeout(function () {
						window.location.assign("/")
				}, 1500)
		}
}
