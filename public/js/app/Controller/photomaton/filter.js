import * as view from '../../View/filter.js'

export class Filter {
	constructor (section, data, screenNode) {
    this.camagru = section.parentNode.parentNode
    this.screenNode = screenNode
		this.section = section
		this.data = data
    this.buildView(view.template)
    this.isActive = false
    this.setEvent()
    this.center = {
      x:0,
      y:0
    }
    this.client = {
      x:null,
      y:null
    }
	}

  setCenter() {
    this.center.y = this.imgNode.height / 2
    this.center.x = this.imgNode.width / 2
  }

  activate() {
    if (!this.isActive) {
      this.imgNode = this.screenNode.appendChild(this.img)
      this.imgNode.classList.add("gg-drag")
      this.setCenter()
      this.addEvents()
      this.isActive = true
    } else {
      this.screenNode.removeChild(this.img)
      this.isActive = false
    }
  }

  startDrag(event) {
    if (!this.client.y) {
      this.client.y = event.clientY
      this.client.x = event.clientX
    }
    this.imgNode.addEventListener("mousemove", this, false)
  }

  drag(event) {
    let y = event.clientY - this.client.y
    let x = event.clientX - this.client.x

    this.imgNode.style.top = y + "px"
    this.imgNode.style.left = x + "px"
  }

  addEvents() {
      this.imgNode.addEventListener("mousedown", this, false)
      this.camagru.addEventListener("keypress", this, false)
      this.camagru.addEventListener("mouseup", this, false)
  }

  removeEvents() {
      this.imgNode.removeEventListener("mousedown", this, false)
      this.camagru.removeEventListener("keypress", this, false)
      this.camagru.removeEventListener("mouseup", this, false)
      this.imgNode.removeEventListener("mousemove", this, false)
  }

  key(event) {
    if (event.key === "Enter") {
      this.removeEvents()
    } else if (event.key === "+") {
      this.imgNode.width += 20
      this.setCenter()
    } else if (event.key === "-") {
      this.imgNode.width -= 20
      this.setCenter()
    }
  }

  setEvent() {
    this.handleEvent = function (event) {
      this.eventDispatcher(event)
    }
    this.node.addEventListener("click", this, false)
  }

	eventDispatcher(event) {
		event.preventDefault()
    event.stopPropagation()

    switch (event.type) {
      case "click":
        this.activate()
        break
      case "mousedown":
        this.startDrag(event)
        break
      case "mousemove":
        this.drag(event)
        break
      case "mouseup":
        this.drag(event)
        this.imgNode.removeEventListener("mousemove", this, false)
        break
      case "keypress":
        this.key(event)
        break
    }
  }

  setNode(img) {
		img.src = this.data.url
		img.alt = this.data.title
		img.title = this.data.title
  }

  setImage() {
    this.img = document.createElement("img")
    this.setNode(this.img)
    this.img.classList.add("gg-screen-width")
    this.img.classList.add("gg-position-filter")
    this.img.style.top = 0
    this.img.style.left = 0
  }

	buildView (template) {
		let tmpNode = (new DOMParser()).parseFromString(template, 'text/html')

    this.setNode(tmpNode.getElementsByTagName("img")[0])
    this.setImage()
		this.node = this.section.appendChild(tmpNode.body.childNodes[0])
  }
}
