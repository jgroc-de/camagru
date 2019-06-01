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
  function init () {
    router()
    components()
  }

  function navbarBtns () {
    burger()
    loginForms()
    navbar()
  }

  function router () {
    const login = new Login.Login()
    const routes = [
      login,
      new Logout.Logout(login),
      new Signup.SignUp(),
      new Contact.Contact()
    ]

    for (let route of routes) {
      formManager(route)
    }
  }

  function components () {
    navbarBtns()
  }

  init()
}

app()
