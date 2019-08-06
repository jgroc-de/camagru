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
	}

  wakeUp () {
    if (this.view) {
      console.log("wakeup " + this.name)
      return this.view.run(false)
    }
	}

	shutDown () {
    if (this.view) {
      console.log("shutdown " + this.name)
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
