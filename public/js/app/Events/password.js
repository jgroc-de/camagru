import {CommonForm} from "./commonForm.js"

export class Password extends CommonForm {
		constructor(name) {
				super(name)
		}

		extra() {
				let forms = this.formContainer.getElementsByTagName('form')

				forms[0].method = "patch"
		}
}
