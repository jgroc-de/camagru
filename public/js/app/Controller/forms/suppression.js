import { FormModal } from '../../Abstract/formModal.js'
import { printNotif } from '../../../Library/printnotif.js'
import { ggAjax } from '../../../Library/ggAjax.js'
import { request } from '../../Abstract/request.js'


export class Suppression extends FormModal {
	constructor (state) {
		super(state, "suppression", "settingsForm")
		this.setFormsMethod()
	}

	setFormsMethod() {
		let forms = this.formContainer.getElementsByTagName('form')

		forms[0].method = "delete"
	}

  submit (event) {
    let inputs = event.target.form

    if (confirm("You are going all your datas (image, comments, likes, etc…). This can not undo this operation. Do you confirm?")) {
      ggAjax(new request(inputs), this)
    }
  }

  callback (response, httpStatus) {
		if (response['flash']) {
      printNotif(response['flash'], httpStatus)
    }
    setTimeout(function () {
      window.location.assign("/")
    }, 1500)
  }
}
