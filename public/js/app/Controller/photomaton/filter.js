import * as view from '../../View/filter.js'
import { getImage } from '../../../Library/image.js'

export class Filter {
	constructor (section, data, screenNode, info) {
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
    this.info = info.getElementsByTagName("div")
    this.buttons = info.getElementsByTagName("button")
	}

  resetCenter() {
    this.img.style.top = "0px"
    this.img.style.left = "0px"
    this.center.x = 0
    this.center.y = 0
    this.client.x = null
    this.client.y = null
  }

  setCenter() {
    this.center.y = this.imgNode.height / 2
    this.center.x = this.imgNode.width / 2
  }

  toggleHide() {
    this.section.classList.toggle("w3-hide")
    this.info[0].classList.toggle("w3-hide")
    this.info[1].classList.toggle("w3-hide")
  }

  activate() {
    if (!this.isActive) {
      this.toggleHide()
      this.imgNode = this.screenNode.appendChild(this.img)
      this.imgNode.classList.add("gg-drag")
      this.setCenter()
      this.addEvents()
      this.isActive = true
      for (let button of this.buttons) {
        button.addEventListener("click", this, false)
      }
      this.section.parentNode.firstChild.classList.add("w3-hide")
    } else {
      this.screenNode.removeChild(this.img)
      this.imgNode = null
      this.isActive = false
      this.resetCenter()
    }
  }

  startDrag(event) {
    if (!this.client.y) {
      this.client.y = event.clientY
      this.client.x = event.clientX
    }
    this.imgNode.addEventListener("mousemove", this, false)
    document.addEventListener("mouseup", this, false)
  }

  drag(event) {
    let y = event.clientY - this.client.y
    let x = event.clientX - this.client.x

    this.imgNode.style.top = y + "px"
    this.imgNode.style.left = x + "px"
  }

  addEvents() {
    document.addEventListener("keypress", this, false)
    this.imgNode.addEventListener("mousedown", this, false)
  }

  removeEvents() {
    this.imgNode.removeEventListener("mousedown", this, false)
    document.removeEventListener("keypress", this, false)
    document.removeEventListener("mouseup", this, false)
    this.imgNode.removeEventListener("mousemove", this, false)
    for (let button of this.buttons) {
      button.removeEventListener("click", this, false)
    }
    this.section.parentNode.firstChild.classList.remove("w3-hide")
  }

  fix() {
    this.removeEvents()
    this.toggleHide()
  }

  zoom(key) {
    if (key === "+") {
      this.imgNode.width += 20
    } else {
      this.imgNode.width -= 20
    }
    this.setCenter()
  }

  key(event) {
    if (event.key === "Enter") {
      this.fix()
    } else if (event.key === "+" || event.key === "-") {
      this.zoom(event.key)
    }
  }

  setEvent() {
    this.handleEvent = function (event) {
      this.eventDispatcher(event)
    }
    this.node.addEventListener("click", this, false)
  }

  click(event) {
    switch (event.target.textContent) {
      case "enter":
        this.fix()
        break
      case "+":
        this.zoom("+")
        break
      case "-":
        this.zoom("-")
        break
      default:
        this.activate()
    }
  }

	eventDispatcher(event) {
		event.preventDefault()
    event.stopPropagation()

    switch (event.type) {
      case "click":
        this.click(event)
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
        document.removeEventListener("mouseup", this, false)
        break
      case "keypress":
        this.key(event)
        break
    }
  }

  setImage() {
    this.img = document.createElement("img")
    getImage(this.img, this.data)
    this.img.classList.add("gg-screen-width")
    this.img.classList.add("gg-position-filter")
    this.img.style.top = 0
    this.img.style.left = 0
  }

	buildView (template) {
		let tmpNode = (new DOMParser()).parseFromString(template, 'text/html')

    //doublon…
    getImage(tmpNode.getElementsByTagName("img")[0], this.data)
    this.setImage()
		this.node = this.section.appendChild(tmpNode.body.childNodes[0])
  }
}
