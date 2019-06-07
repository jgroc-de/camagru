export function middleware (state) {
  let logins = [
    "camagru",
    "like",
    "comment",
  ]
  let index = logins.indexOf(state.route)

  if (index !== -1 && !state.isLogin()) {
    window.location.assign('#login')
    return false
  }

  return state.route
}
