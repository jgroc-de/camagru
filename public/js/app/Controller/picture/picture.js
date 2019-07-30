import { newPage } from '../../Abstract/newPage.js'
import * as view from '../../View/picture.js'
import { PictureManager } from './Picture/pictureManager.js'
import { CommentsManager } from './Comments/commentsManager.js'

export class Picture extends newPage {
	constructor (state) {
		super(state, 'Picture', [
			'Pictures', 'Camagru'
		], view)
		this.PictureManager = new PictureManager(this.card.getElementsByTagName('section')[0], this.state)
		this.CommentsManager = new CommentsManager(this.card.getElementsByTagName('section')[1], this.state)
	}
}
