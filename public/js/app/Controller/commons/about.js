import { Controller } from '../../AnGGular/controller.js'
import { HiddenView } from '../../AnGGular/Views/hidden.js'
import { Events } from './Events/aboutE.js'

export class About extends Controller {
	constructor (state, name = "about") {
		super({
      state: state,
      name: name,
      view: null,
      events: new Events()
    })
	}
}
