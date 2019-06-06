'use strict'
import { burger } from './Components/navbar/burger.js'
import { loginForms } from './Components/navbar/loginForms.js'
import { navbar } from './Components/navbar/navbar.js'
import * as Login from './Routes/login.js'
import * as Logout from './Routes/logout.js'
import * as Signup from './Routes/signup.js'
import * as Contact from './Routes/contact.js'
import { formManager } from './Library/formManager.js'

function app () {
  let hash = window.location.hash

  console.log(hash)
}

app()
window.onhashchange = function () {
  app()
}
