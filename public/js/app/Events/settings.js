import { CommonForm } from "./commonForm.js"
import { request } from '../Abstract/request.js'
import { ggAjax } from '../../Library/ggAjax.js'
import { printNotif } from '../../Library/printnotif.js'

export class Settings extends CommonForm {
  constructor(name) {
    super(name)
  }

  extra() {
		this.getUser()
		this.setFormsMethod()
  }

	setFormsMethod() {
		let forms = this.formContainer.getElementsByTagName('form')

		forms[0].method = "patch"
	}

	getUser() {
		let form = {
			method: "Get",
			url: "/user",
			body: {},
    }

    ggAjax(form, this)
  }

  checkboxManager (response, checkbox) {
    let isChecked = response.settings.alert ? true : false

    if (!isChecked) {
      checkbox.click()
    }
  }

  setInput (response, input) {
    let name = input.name

    if (!response.settings[name]) {
      return
    }
    switch (name) {
      case "alert":
        this.checkboxManager(response, input)
        break;
      default:
        input.value = response.settings[name]
    }
  }

  updateForm (response) {
    let inputs = this.formContainer.children[1].getElementsByTagName('input')
    let i = 0
    let name = ''
    let input

    while (i < inputs.length) {
      this.setInput(response, inputs[i++])
    }
  }

  callback (response, httpStatus) {
		if (response['flash']) {
			printNotif(response['flash'], httpStatus)
		}
    if (!response.settings) {
      return
    }
    this.updateForm(response)
  }
}
