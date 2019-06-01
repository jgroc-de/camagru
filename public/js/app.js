'use strict'
import { burger } from './Components/navbar/burger.js'
import { loginForms } from './Components/navbar/loginForms.js'
import { navbar } from './Components/navbar/navbar.js'
import * as Login from './Routes/login.js'
import * as Logout from './Routes/logout.js'
import * as Signup from './Routes/signup.js'
import { formManager } from './Library/formManager.js'

function app () {
  function init () {
    components()
    routes()
  }

  function navbarBtns () {
    burger()
    loginForms()
    navbar()
    /* logout () {
      let logoutForm = {
        method:'delete',
        action:'localhost:8888/logout'
      }
      ggAjax('', logoutForm, this)
    } */
  }

  function routes () {
    const login = new Login.LoginRoute()
    const logout = new Logout.LogoutRoute()
    const signup = new Signup.SignUpRoute()

    formManager(login)
    formManager(logout)
    formManager(signup)
  }

  function components () {
    navbarBtns()
  }

  init()
}

app()
