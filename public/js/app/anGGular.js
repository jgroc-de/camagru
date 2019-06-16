import { router } from './router.js'
import { middlewares } from './middleware.js'
import { ggAjax } from '../Library/ggAjax.js'

export class anGGularJS {
	constructor (state) {
		this.state = state
	}

	launch () {
		let route = middlewares(router(this.state))

		if (route) {
			const controller = './Controller/' + route + '.js'

			import(controller)
				.then((module) => {
					let key = Object.keys(module)[0]
					if (!this.state.components[key]) {
						this.state.components[key] = new module[key](this.state)
					}
					this.state.components[key].wakeUp()
					console.log(this.state)
				})
		}
	}

	checkLogin () {
		//check if is logged on server
		const controller = './Controller/login.js'

		import(controller).then((module) => {
			let request = {
				method: "Get",
				url: "/user",
				body: {},
			}
			let hash = window.location.hash.replace("#", "")

			this.state.components.Login = new module.Login(this.state)
			this.state.components.Login.redirect = hash;
			ggAjax(request, this.state.components.Login)
		})
	}
}
