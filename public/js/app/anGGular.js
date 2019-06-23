import { router } from './router.js'
import { middlewares } from './middleware.js'
import { ggAjax } from '../Library/ggAjax.js'

export class anGGularJS {
	constructor (state) {
		this.state = state
	}

	launch () {
		try {
			let route = middlewares(router(this.state))
			const controller = './Controller/' + route + '.js'
			console.log("route: " + route)

			if (route) {
				import(controller)
					.then((module) => {
						let key = Object.keys(module)[0]
						if (!this.state.components[key]) {
							this.state.components[key] = new module[key](this.state)
						}
						this.state.components[key].wakeUp()
						console.log("state:")
						console.log(this.state)
					})
			}
		} catch(error) {
			console.log(error)
		}
	}

	checkLogin () {
		try {
			//check if is logged on server
			const controller = './Controller/login.js'
			console.log("login")

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
