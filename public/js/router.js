/**
import { burger } from './Components/navbar/burger.js'
import { loginForms } from './Components/navbar/loginForms.js'
import { navbar } from './Components/navbar/navbar.js'
import * as Login from './Routes/login.js'
import * as Logout from './Routes/logout.js'
import * as Signup from './Routes/signup.js'
import { formManager } from './Library/formManager.js'
*/

function addEvent(context) {
  context.button.addEventListener(context.eventType, context.listener)
}

export function router(route) {
  let routes = [
    "contact",
    "pictures",
  ]
  let actions = []

  if (routes.includes(route)) {
    actions.push(addEvent)
  }

  return actions
}
