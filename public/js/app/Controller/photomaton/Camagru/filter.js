export class Filter {
	constructor (node, param) {
		this.node = node
		this.configure(param)
		this.parameters = param
	}

	configure (param) {
		let img = this.node.children[0]

		this.node.id = param.title
		img.src = param.url
		img.alt = param.title
		img.title = param.title
	}
}
