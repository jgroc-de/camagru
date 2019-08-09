import { ggAjax } from '../../../Library/ggAjax.js'
import { printNotif } from '../../../Library/printnotif.js'

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
		this.upload = document.getElementById('upload')
    this.upload.addEventListener('change', this, false)
    this.reader = new FileReader()
    this.reader.addEventListener('load', this, false)
	}

  onChange() {
    let file = this.upload.files[0]

    this.reader.readAsDataURL(file)
    this.screen.poster = URL.createObjectURL(file)
  }

  readFile(event) {
    this.upload.src = this.reader.result;
  }

	getDataUrl() {
		if (this.screen.srcObject) {
			let context = this.canvas.getContext('2d')

			context.drawImage(this.screen, 0, 0, 400, 300)
			return this.canvas.toDataURL('image/png')
		} else if (this.upload.src) {
		  return this.upload.src
    }

    return false
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

    if (!dataUrl) {
      printNotif('You must activate the webcam or upload a picture first!', 400)
    } else {
      this.sendShot(dataUrl, filters)
      printNotif('On fait chauffer les hamsters, votre photo arrive!', 200)
    }
	}

	callback(response, httpStatus) {
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
				break
      case 'load':
        this.readFile(event)
        break
      case 'change':
        this.onChange()
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
