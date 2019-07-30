import { anGGularJS } from './app/anGGular.js'

let state = {
	components: {},
	url: window.location.origin,
	route: "",
  id: 1,
	login: {
		pseudo: "",
		id: -1,
	},
	httpStatus: 200,
	isLogin () {
		return (this.login.pseudo !== "")
	},
	destroyLogin () {
		this.login.pseudo = ""
	},
	setLogin (user) {
		this.login.pseudo = user.pseudo
		this.login.id = user.id
	}
}

let app = new anGGularJS(state)

window.onload = function () {
	app.checkLogin()
}

window.onhashchange = function () {
	app.launch()
}
