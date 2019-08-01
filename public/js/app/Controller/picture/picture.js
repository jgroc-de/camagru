import { newPage } from '../../Abstract/newPage.js'
import * as view from '../../View/picture.js'
import { PicturePage } from './PicturePage/picturePage.js'
import { CommentsPage } from './CommentsPage/commentsPage.js'

export class Picture extends newPage {
	constructor (state) {
		super(state,
      'Picture',
      [
			  'Pictures',
        'Camagru',
		  ],
      view
    )
		let sections = this.card.getElementsByTagName('section')
		this.PictureManager = new PicturePage(sections[0], this.state)
		this.CommentsManager = new CommentsPage(sections[1], this.state)
	}
}
