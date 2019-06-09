import { anGGularJS } from './app/anGGular.js'

let state = {
  components: {},
  url: window.location.origin,
  route: "index",
  login: {
    pseudo: "",
  },
  isLogin () {
    return (this.login.pseudo !== "")
  },
  destroyLogin () {
    this.login.pseudo = ""
  },
  setLogin (pseudo) {
    this.login.pseudo = pseudo
  },
  httpStatus: 200
}

let app = new anGGularJS(state)

window.onload = function () {
  app.checkLogin()
}

window.onhashchange = function () {
  app.launch()
}
