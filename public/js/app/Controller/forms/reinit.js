import { FormModal } from '../../Abstract/formModal.js'
import { printNotif } from '../../../Library/printnotif.js'

export class Reinit extends FormModal {
	constructor (state) {
		super(state, "reinit", "authForm")
	}
}
