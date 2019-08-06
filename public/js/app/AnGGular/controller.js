export class Controller {
	constructor (init) {
		this.state = init.state
		this.name = init.name
    this.view = init.view
    this.events = init.events
		this.resetView(init.components)
		this.buildView(init.template)
    if (this.view) {
      this.view.init()
    }
		this.card = document.getElementById(this.name)
    if (this.events) {
      this.events.init(this.card)
    }
    this.setCloseButtons("settingsForm")
    this.setCloseButtons("authForm")
	}

  setCloseButtons(name) {
		let form = document.getElementById(name)
    let path = "#" + this.state.route

    if (this.state.id) {
      path += "/" + this.state.id
    }

    form.getElementsByTagName("a")[0].href = path
  }

  wakeUp () {
    let keys = Object.keys(this.state.components)

    for (let key of keys) {
      if (this.state.components[key].view) {
        this.state.components[key].view.run(true)
      }
    }
    if (this.view) {
      return this.view.run(false)
    }
	}

	shutDown () {
    if (this.view) {
      this.view.run(true)
    }
  }

  resetView (components) {
    if (components) {
      for (let name of components) {
        if (this.state['components'][name]) {
          let card = this.state['components'][name].card

          card.parentNode.removeChild(card)
          delete this.state['components'][name]
        }
      }
    }
  }

  buildView (view) {
    if (view) {
      let anchor = document.getElementById('notif')
      let template = (new DOMParser()).parseFromString(view.template, 'text/html')

      anchor.parentNode.insertBefore(
        template.body.childNodes[0],
        anchor.nextElementSibling
      )

      return template
    }
	}
}
