function restrictedArea (state) {
	let logins = [
		"camagru",
		"settings",
		"password",
		"like",
		"comment",
	]
	let index = logins.indexOf(state.route)

	if (index !== -1 && !state.isLogin()) {
		state.components.Login.redirect = state.route
		state.httpCode = 403
		window.location.assign('#login')
		return false
	}

	return true
}

function anonymousArea (state) {
	let logins = [
		"login",
		"reinit",
		"signup",
	]
	let index = logins.indexOf(state.route)

	if (index !== -1 && state.isLogin()) {
		state.httpCode = 403
		window.location.assign('#error')
		return false
	}

	return true
}

export function middlewares (state) {
	if (!restrictedArea(state)
		|| !anonymousArea(state)
	) {
		return false
	}

	return state.route
}
