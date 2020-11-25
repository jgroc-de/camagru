import {PicturePage} from '../Controller/picture/PicturePage/picturePage.js'
import {CommentsPage} from '../Controller/picture/CommentsPage/commentsPage.js'

export class Picture {
		constructor(name, state) {
				this.name = name
				this.state = state
		}

		init(card) {
				this.sections = card.getElementsByTagName('section')
				this.PictureManager = new PicturePage(this.sections[0], this.state)
				this.CommentsManager = new CommentsPage(this.sections[1], this.state)
		}

		toggleLogin() {
				this.CommentsManager.renew(this.state)
				this.PictureManager.title.setEvent()
		}

		async resetComments() {
				this.CommentsManager.reset()
				this.CommentsManager.init()
		}

		async resetPicture() {
				this.PictureManager.reset()
				this.PictureManager.init()
		}

		reinit() {
				this.resetComments()
				this.resetPicture()
		}
}
