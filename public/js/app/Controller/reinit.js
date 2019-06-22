import { FormModal } from '../Abstract/form.js'
import { printNotif } from '../../Library/printnotif.js'

export class Reinit extends FormModal {
	constructor (state) {
		super(state, "reinit", "authForm")
	}
}
