import { FormModal } from '../Abstract/form.js'
import { printNotif } from '../../Library/printnotif.js'


export class Signup extends FormModal {
	constructor (state) {
		super(state, 'signup', "authForm")
	}
}
