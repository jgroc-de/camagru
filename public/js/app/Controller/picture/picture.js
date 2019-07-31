import { newPage } from '../../Abstract/newPage.js'
import * as view from '../../View/picture.js'
import { PicturePage } from './PicturePage/picturePage.js'
import { CommentsPage } from './CommentsPage/commentsPage.js'

export class Picture extends newPage {
	constructor (state) {
		super(state, 'Picture', [
			'Pictures', 'Camagru'
		], view)
		this.PictureManager = new PicturePage(this.card.getElementsByTagName('section')[0], this.state)
		this.CommentsManager = new CommentsPage(this.card.getElementsByTagName('section')[1], this.state)
	}
}
