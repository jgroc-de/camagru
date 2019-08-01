import { ggAjax } from '../../../../Library/ggAjax.js'

export class Photographer {
	constructor () {
		this.button = document.getElementById('snap');
		this.video = document.getElementById('video');
		this.webcamON()
		this.handleEvent = function (event) {
			this.eventDispatcher(event)
		}
		this.canvas = document.getElementById('canvas');
		this.button.addEventListener('click', this, false);
	}

	eventDispatcher(event) {
		event.preventDefault()
		event.stopPropagation()

		switch(event.type) {
			case 'click':
				this.submit(event)
				break;
			default:
		}
	}

	webcamON() {
		if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
      console.log('here')
			navigator.mediaDevices.getUserMedia({ video: true })
				.then(function(stream) {
          console.log('here2')
					let screen = document.getElementById('screen')

					screen.srcObject = stream
					screen.play()
          console.log(screen)
				})
      console.log(navigator.mediaDevices)
		}
	}

	submit() {
		let dataUrl = this.getDataUrl()
		let titles = this.getTitles()
		let str = this.imageToString(dataUrl, titles)

		this.createPic(str)
		//printNotif('On fait chauffer les hamsters, votre photo arrive!', 200)
	}

	getTitles() {
		let titles = [];
		let	filters = document.querySelectorAll('img[alt=visible]')
		let i = 0;

		while (i < filters.length) {
			titles.push(filters[i++].id)
		}

		return titles
	}

	getDataUrl() {
		let upload = document.getElementById('upload')

		if (!upload) {
			console.log("canvas" + this.canvas)
			let context = this.canvas.getContext('2d')

			context.drawImage(this.video, 0, 0, 640, 480)
			return this.canvas.toDataURL('image/png')
		}

		return upload.src
	}

	imageToString(data, filters) {
		let i = 0

		while (i < filters.length) {
			data += '&title' + i + '=' + filters[i]
			i++
		}
		return data
	}

	createPic(str) {
		let request = {
			method: "Post",
			url: "/picture",
			body: {
				picture: str
			},
		}

		ggAjax(request, this)
	}

	callback(response) {
		console.log("callback photo " + response)
		var main = document.getElementById('new')
		var first = picDivFactory(json)
		var path = json['path']

		main.insertBefore(first, main.firstChild)
	}
}
