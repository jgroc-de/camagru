import { Controller } from '../../AnGGular/controller.js'
import { HiddenView } from '../../AnGGular/Views/hidden.js'
import * as template from '../../View/pictures.js'
import { Events } from './Pictures/events.js'

export class Pictures extends Controller {
  constructor (state, name = "Pictures") {
		super({
      state: state,
      name: name,
      components: [
			  'Camagru',
        'Picture',
		  ],
      template: template,
      view: new HiddenView(name),
      events: new Events(name),
    })
    console.log(this)
  }
}
