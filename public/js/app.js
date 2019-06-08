import { router } from './router.js'
import { middlewares } from './middleware.js'

let state = {
  components: {},
  url: window.location.origin,
  route: "index",
  login: {
    name: "",
    isLogin: false
  },
  isLogin () {
    return this.login.isLogin
  },
  destroyLogin () {
    this.login.isLogin = false
    this.login.name = ""
  },
  setLogin (name) {
    this.login.isLogin = true
    this.login.name = name
  },
  httpStatus: 200
}

function app (state) {
  let route = middlewares(router(state))

  if (route) {
    const controller = './Controller/' + route + '.js'

    import(controller)
      .then((module) => {
        let key = Object.keys(module)[0]
        if (!state.components[key]) {
          state.components[key] = new module[key](state)
        }
        state.components[key].wakeUp()
      })
  }
}

window.onload = function () {
  app(state)
}

window.onhashchange = function () {
  app(state)
  console.log(state)
}
