import {getImage} from '../../../Library/image.js'

export class Shot {
		constructor(node, param) {
				this.node = node
				this.configure(param)
				this.parameters = param
		}

		configure(param) {
				let title = this.node.children[0]
				let img = this.node.children[1]

				this.node.id = param.title
				getImage(img, param)
				title.innerText = param.title
				this.node.href = "#picture/" + param.id
		}
}
