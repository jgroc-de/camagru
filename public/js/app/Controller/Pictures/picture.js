export class Picture {
	constructor (node, param) {
		this.node = node.body.children[0]
		this.configure(param)
		this.parameters = param
	}

	configure (param) {
		let box = this.node
		let title = box.children[0]
		let img = box.children[1]

		this.node.id = param.title
		img.src = param.url
		img.alt = param.title
		img.title = param.title
		title.innerText = param.title
		box.href = "#picture/" + param.id
	}
}
