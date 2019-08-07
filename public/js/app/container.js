import { Controller } from './AnGGular/controller.js'
import { Login } from './Events/login.js'

export class Container {
  constructor(state) {
    this.state = state
    this.setEvents()
    this.setBehaviour()
    this.setComponents()
    this.setTemplates()
  }

  key(module) {
    return Object.keys(module)[0]
  }

  setEvents() {
   this.events = {
     login: true,
     reinit: true,
     signup: true,
     picture: true,
     pictures: true,
     about: true,
     contact: true,
     camagru: true,
   }
  }

  setBehaviour() {
   this.view = {
     login: ["modal", "authForm"],
     reinit: ["modal", "authForm"],
     signup: ["modal", "authForm"],
     pictures: ["hidden"],
     burger: ["burger", this.state],
     logout: ["logout", this.state],
     error: ["error"]
   }
  }

  setComponents() {
    this.components = {
      picture: [
			  'pictures',
        'camagru',
      ],
      pictures: [
        'picture',
        'camagru',
      ],
      camagru: [
        'picture',
        'pictures',
      ],
    }
  }

  setTemplates() {
    this.templates = {
      picture: true,
      pictures: true,
      camagru: true,
    }
  }

  async getBehaviour(name) {
    let behaviour = this.view[name]

    if (behaviour) {
      let path =  "./Behaviour/" + behaviour[0] + ".js"
      let module = await import(path)

      return new module[this.key(module)](name, behaviour[1])
    }

    return null
  }

  async getTemplate(name) {
    if (this.templates[name]) {
      let path = "./View/" + name + ".js"
      let module = await import(path)

      return module.template
    }

    return null
  }

  async getEvent(name) {
    if (this.events[name]) {
      let path = "./Events/" + name + ".js"
      let module = await import(path)

      return new module[this.key(module)](name, this.state)
    }

    return null
  }

  async start(name, wakeUp = true) {
    if (!this.state.components[name]) {
      let params = {
        state: this.state,
        name: name,
        components: this.components[name],
        template: await this.getTemplate(name),
        view: await this.getBehaviour(name),
        events: await this.getEvent(name),
      }
      this.state.components[name] = new Controller(params)
    }
    if (wakeUp) {
      this.state.components[name].wakeUp()
    }
  }
}
