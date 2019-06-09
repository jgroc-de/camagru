export function router(state) {
  let hash = window.location.hash.replace("#", "")
  let routes = [
    "about",
    "burger",
    "camagru",
    "contact",
    "error",
    "login",
    "logout",
    "reinit",
    "signup",
    "settings",
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


