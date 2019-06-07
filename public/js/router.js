export function router(state) {
  let hash = window.location.hash.replace("#", "")
  let routes = [
    "about",
    "burger",
    "contact",
    "error",
    "login",
    "logout",
    "reinit",
    "signup",
    "camagru"
  ]
  let index = routes.indexOf(hash)

  if (index !== -1) {
    state.route = hash
  } else if (hash === "") {
    state.route = "index"
  } else {
    state.httpStatus = 404
    window.location.assign("#error")
    return false
  }

  return state
}


