import { ggAjax } from '../../../../Library/ggAjax.js'
import { printNotif } from '../../../../Library/printnotif.js'

export class Photographer {
	constructor (MyPictures) {
    this.MyPictures = MyPictures
		this.button = document.getElementById('snap');
		this.screen = document.getElementById('screen');
		this.canvas = document.getElementById('canvas');
		this.webcamON()
		this.handleEvent = function (event) {
			this.eventDispatcher(event)
		}
		this.button.addEventListener('click', this, false);
	}

	getDataUrl() {
		let upload = document.getElementById('upload')

		if (!upload) {
			let context = this.canvas.getContext('2d')

			context.drawImage(this.screen, 0, 0, 640, 480)
			return this.canvas.toDataURL('image/png')
		}

		return upload.src
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

	imageToString(data, filters) {
		let i = 0

		while (i < filters.length) {
			data += '&title' + i + '=' + filters[i]
			i++
		}
		return data
	}

	sendShot(str) {
		let request = {
			method: "Post",
			url: "/picture",
			body: {
				picture: str
			},
		}

		ggAjax(request, this)
	}

	submit() {
		let dataUrl = this.getDataUrl()
		let titles = this.getTitles()
		let str = this.imageToString(dataUrl, titles)

		this.sendShot(str)
		printNotif('On fait chauffer les hamsters, votre photo arrive!', 200)
	}

	callback(response, httpStatus) {
    console.log("callback photo ")
    console.log(response)
    if (httpStatus === 201) {
		  printNotif('It\'s online!!', 200)
      this.MyPictures.add(response)
    }
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
			navigator.mediaDevices.getUserMedia({ video: true })
				.then(function(stream) {
					let screen = document.getElementById('screen')

					screen.srcObject = stream
					screen.play()
				})
		}
	}
}
