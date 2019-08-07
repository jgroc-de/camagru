function getHash() {
	let hash = window.location.hash

  hash = hash.replace("#", "").replace("!", "").toLowerCase()

  return hash.split('/')
}

export function router(state) {
  console.log(state)
	let hash = getHash()
	let routes = [
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

  if (index > 7) {
    state.prevRoute = state.route
    if (state.id) {
      state.prevRoute += "/" + state.id
    }
  }
  if (index !== -1) {
		state.route = hash[0]
    if (hash[1]) {
		  state.id = hash[1]
    } else {
      state.id = null
    }
	} else if (hash[0] === "") {
		state.route = "pictures"
	} else {
    console.log(hash)
		state.httpStatus = 404
		window.location.assign("#error")
	}

	return state
}
