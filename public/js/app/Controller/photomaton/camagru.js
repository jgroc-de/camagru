import { newPage } from '../../Abstract/newPage.js'
import * as view from '../../View/camagru.js'
import { Photographer } from './Camagru/photographer.js'
import { FilterManager } from './Camagru/filterManager.js'

export class Camagru extends newPage {
	constructor (state) {
		super(state,
      'Camagru',
      [
			  'Pictures',
        'Picture',
		  ],
      view
    )
		let sections = this.card.getElementsByTagName('section')
		this.FilterManager = new FilterManager(sections[1])
		this.Photographer = new Photographer()
	}
}
