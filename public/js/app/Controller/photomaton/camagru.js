import { Controller } from '../../AnGGular/controller.js'
import * as template from '../../View/camagru.js'
import { Events } from './Camagru/events.js'

export class Camagru extends Controller {
	constructor (state, name = "Camagru") {
		super({
      state: state,
      name: name,
      components: [
			  'Pictures',
        'Picture',
		  ],
      template: template,
      view: null,
      events: new Events(name),
    })
	}
}
