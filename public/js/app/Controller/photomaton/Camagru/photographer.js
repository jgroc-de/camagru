import { ggAjax } from '../../../../Library/ggAjax.js'
import { printNotif } from '../../../../Library/printnotif.js'

export class Photographer {
	constructor (MyPictures) {
    this.MyPictures = MyPictures
		this.button = document.getElementById('snap');
		this.screen = document.getElementById('screen');
		this.canvas = document.getElementById('canvas');
		this.filtersON = document.getElementById('montage');
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

			context.drawImage(this.screen, 0, 0, 400, 300)
			return this.canvas.toDataURL('image/png')
		}

		return upload.src
	}

	getFilters() {
		let filters = [];
		let	imgs = this.filtersON.getElementsByTagName('img')
		let i = 0;

		while (i < imgs.length) {
			filters.push({
        title:imgs[i].title,
        y:imgs[i].style.top,
        x:imgs[i].style.left,
        width:imgs[i].width,
      })
      i++
		}

		return filters
	}

	sendShot(dataUrl, filters) {
		let request = {
			method: "Post",
			url: "/picture",
			body: {
				picture: dataUrl,
        filters: filters
			},
		}

		ggAjax(request, this)
	}

	submit() {
		let dataUrl = this.getDataUrl()
		let filters = this.getFilters()

		this.sendShot(dataUrl, filters)
		printNotif('On fait chauffer les hamsters, votre photo arrive!', 200)
	}

	callback(response, httpStatus) {
    console.log("callback photo ")
    console.log(response)
    if (httpStatus === 201) {
		  printNotif('It\'s online!!', httpStatus)
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
