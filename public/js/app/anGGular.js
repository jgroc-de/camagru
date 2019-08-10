import { router } from './router.js'
import { middlewares } from './middleware.js'
import { Container } from './container.js'

export class anGGularJS {
	constructor (state) {
		this.state = state
    this.container = new Container(state)
	}

  errorManager(error) {
		console.log(error)
  }

	async launch () {
    try {
      let route = middlewares(router(this.state))

      console.log(this.state.components)
      if (route) {
        await this.container.start(route)
      }
      console.log(this.state.components)
		} catch(error) {
      this.errorManager(error)
		}
	}

  async checkLogin () {
    try {
      //check if is logged on server
      await this.container.start("login", false)
      this.launch()
    } catch(error) {
      this.errorManager(error)
		}
	}
}
