import { router } from './router.js'
import { middlewares } from './middleware.js'
import { ggAjax } from '../Library/ggAjax.js'

export class anGGularJS {
	constructor (state) {
		this.state = state
	}

  path (route) {
    if (["suppression", "settings", "password", "login", "signup", "reinit"].includes(route)) {
      return "forms/" + route
    } else if (["pictures"].includes(route)) {
      return "home/" + route
    } else if (["about", "contact"].includes(route)) {
      return "commons/" + route
    } else if (["picture"].includes(route)) {
      return "picture/" + route
    } else if (["burger", "logout"].includes(route)) {
      return "navbar/" + route
    } else if (["camagru"].includes(route)) {
      return "photomaton/" + route
    } else {
      return route
    }
  }

	launch () {
		try {
			let route = this.path(middlewares(router(this.state)))
			const controller = './Controller/' + route + '.js'

			if (route) {
				import(controller)
					.then((module) => {
						let key = Object.keys(module)[0]

            console.log(key)
						if (!this.state.components[key]) {
              console.log("creation")
							this.state.components[key] = new module[key](this.state)
						}
						this.state.components[key].wakeUp()
					})
			}
		} catch(error) {
    	console.log(error)
		}
	}

	checkLogin () {
		try {
			//check if is logged on server
			let route = this.path("login")
			const controller = './Controller/' + route + '.js'

			import(controller).then((module) => {
				let request = {
					method: "Get",
					url: "/user",
					body: {},
				}
				this.state.components.Login = new module.Login(this.state)
				ggAjax(request, this.state.components.Login)
			}).then(() => {
				this.launch()
			})
		} catch(error) {
			console.log(error)
		}
	}
}
