import { FormModal } from '../../Abstract/formModal.js'
import { printNotif } from '../../../Library/printnotif.js'
import { ggAjax } from '../../../Library/ggAjax.js'


export class Password extends FormModal {
	constructor (state) {
		super(state, "password", "settingsForm")
		this.setFormsMethod()
	}

	setFormsMethod() {
		let forms = this.formContainer.getElementsByTagName('form')

		forms[0].method = "patch"
	}

  callback (response, httpStatus) {
		if (response['flash']) {
			printNotif(response['flash'], httpStatus)
		}
  }
}
