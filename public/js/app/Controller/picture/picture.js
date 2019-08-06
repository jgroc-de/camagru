import { Controller } from '../../AnGGular/controller.js'
import * as template from '../../View/picture.js'
import { PicturePage } from './PicturePage/picturePage.js'
import { CommentsPage } from './CommentsPage/commentsPage.js'

export class Picture extends Controller {
	constructor (state, name = "Picture") {
		super({
      state: state,
      name: name,
      components: [
			  'Pictures',
        'Camagru',
		  ],
      template: template,
      view: null,
      events: null,
    })
		let sections = this.card.getElementsByTagName('section')
		this.PictureManager = new PicturePage(sections[0], this.state)
		this.CommentsManager = new CommentsPage(sections[1], this.state)
	}
}
