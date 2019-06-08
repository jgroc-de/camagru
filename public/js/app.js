import { router } from './router.js'
import { middlewares } from './middleware.js'
import { ggAjax } from './Library/ggAjax.js'

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
  setLogin (name) {
    this.login.pseudo = name
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
  const controller = './Controller/login.js'

  import(controller).then((module) => {
    let form = {
      method: "Get",
      url: "/user",
      body: {},
    }

    state.components['Login'] = new module['Login'](state)
    ggAjax(form, state.components['Login'])
  })
  app(state)
}

window.onhashchange = function () {
  app(state)
  console.log(state)
}
