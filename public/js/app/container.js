import { Controller } from './AnGGular/controller.js'
import { Login } from './Events/login.js'

export class Container {
  constructor(state) {
    this.state = state
    this.setEvents()
    this.setBehavior()
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
     password: true,
     settings: true,
     suppression: true,
     picture: true,
     pictures: true,
     about: true,
     contact: true,
     camagru: true,
   }
  }

  setBehavior() {
    let modal1 = {
      state: this.state,
      modal: "authForm",
    }
    let modal2 = {
      state: this.state,
      modal: "settingsForm",
    }

    this.behavior = {
      login: ["modal", modal1],
      reinit: ["modal", modal1],
      signup: ["modal", modal1],
      password: ["modal", modal2],
      settings: ["modal", modal2],
      suppression: ["modal", modal2],
      pictures: ["hidden"],
      burger: ["burger", this.state],
      logout: ["logout", this.state],
      error: ["error", this.state],
      picture: ["picture", this.state],
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

  async getBehavior(name) {
    let behavior = this.behavior[name]

    if (behavior) {
      let path =  "./Behavior/" + behavior[0] + ".js"
      let module = await import(path)

      return new module[this.key(module)](name, behavior[1])
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
        view: await this.getBehavior(name),
        events: await this.getEvent(name),
      }
      this.state.components[name] = new Controller(params)
    }
    if (wakeUp) {
      this.state.components[name].wakeUp()
    }
  }
}
