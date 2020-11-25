function getHash() {
		let hash = window.location.hash

		if (hash === "") {
				let path = window.location.pathname

				path = path.replace(/^\//, "#")
				window.location.assign(window.location.origin + "/" + path)
		}
		hash = hash.replace("#", "").replace("!", "").toLowerCase()

		return hash.split('/')
}

function setPrevRoute(index, state) {
		if (index > 9) {
				state.prevRoute = "#" + state.route
				if (state.id) {
						state.prevRoute += "/" + state.id
				}
		}
}

export function router(state) {
		let hash = getHash()
		let routes = [
				"",
				"error",
				"login",
				"logout",
				"reinit",
				"signup",
				"settings",
				"password",
				"suppression",
				"burger",
				"about",
				"camagru",
				"contact",
				"pictures",
				"picture",
		]
		let index = routes.indexOf(hash[0])

		if (index !== -1) {
				if (hash[0] === "") {
						state.route = "pictures"
				} else {
						state.route = hash[0]
				}
				if (hash[1]) {
						state.id = hash[1]
				} else {
						state.id = null
				}
				setPrevRoute(index, state)
		} else {
				state.httpStatus = 404
				state.error = "Not Found"
				window.location.assign("#error")
		}

		return state
}
