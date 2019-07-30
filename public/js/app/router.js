function getHash() {
	let hash = window.location.hash

  hash = hash.replace("#", "").replace("!", "").toLowerCase()

  return hash.split('/')
}

export function router(state) {
	let hash = getHash()
  console.log(hash)
	let routes = [
		"about",
		"burger",
		"camagru",
		"contact",
		"error",
		"login",
		"logout",
		"pictures",
    "picture",
		"reinit",
		"signup",
		"settings",
		"password",
    "suppression",
	]
	let index = routes.indexOf(hash[0])

	if (index !== -1) {
		state.route = hash[0]
    if (hash[1]) {
		  state.id = hash[1]
    }
	} else if (hash[0] === "") {
		state.route = "pictures"
	} else {
		state.httpStatus = 404
		window.location.assign("#error")
	}

	return state
}
