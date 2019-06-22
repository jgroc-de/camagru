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
    let form = this.card.children[1]
    let i = 0
    let name = ''
    let input

    while (i < form.length) {
      this.setInput(response, form[i++])
    }
  }

  callback (response) {
    if (!response.settings) {
      return
    }
    this.updateForm(response)
  }
}
