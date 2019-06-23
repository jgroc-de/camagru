import { FormModal } from '../Abstract/formModal.js'
import { printNotif } from '../../Library/printnotif.js'
import { ggAjax } from '../../Library/ggAjax.js'


export class Settings extends FormModal {
	constructor (state) {
		super(state, "settings", "settingsForm")
		this.getUser()
		this.setFormsMethod()
	}

	setFormsMethod() {
		let forms = this.formContainer.getElementsByTagName('form')

		forms[0].method = "patch"
		forms[1].method = "patch"
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

    if (checkbox.checked !== isChecked) {
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

		console.log('inputs')
		console.log(inputs)
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
