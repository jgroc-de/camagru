import * as Contact from './Controller/contact.js'
import { router } from './router.js'

let state = {
  route:[]
}

function kamehameha(route, controller, actions) {
  let i = 0

  while (i < actions.length) {
    actions[i++](controller)
  }
  controller.view()
}

function app (state) {
  let route = window.location.hash.replace("#", "")
  let actions = router(route)

  if (route !== "") {
    const controller = './Controller/' + route + '.js'

    import(controller)
      .then((module) => {
        let key = Object.keys(module)[0]
        let context = new module[key]()

        state.route.push(context)
        kamehameha(route, context, actions)
      })
  } else {
    while (state.route.length) {
      state.route.shift().view()
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
