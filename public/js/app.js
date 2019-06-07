let state = {
  components : {},
  url:window.location.origin,
  login : {
    name:"",
    isLogin:false
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
  }
}

function app (state) {
  let route = window.location.hash.replace("#", "")

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
  } else {
    for (let i in state.components) {
      state.components[i].shutDown()
    }
  }
}

window.onload = function () {
  app(state)
}

window.onhashchange = function () {
  app(state)
  console.log(state)
}
