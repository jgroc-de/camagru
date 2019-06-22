import { hiddenController } from '../Abstract/hiddenController.js'
import { Form } from '../../Library/form.js'

export class Contact extends hiddenController {
	constructor (state) {
		super(state, "contact")
		this.form = new Form(this.name, this.card)
	}
}
