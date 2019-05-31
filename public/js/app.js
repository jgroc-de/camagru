'use strict'

function app() {
  function init() {
    components()
    routes()
  }

  function navbarBtns() {

    burger()
    loginForms()
    navbar()
    /*logout () {
      let logoutForm = {
        method:'delete',
        action:'localhost:8888/logout'
      }
      ggAjax('', logoutForm, this)
    }*/
  }

  function routes() {
    const login = new LoginRoute()
    const logout = new LogoutRoute()
    const signup = new SignUpRoute()

    formManager(login)
    formManager(logout)
    formManager(signup)
  }

  function components() {
    navbarBtns()
  }

  init()
}

app()
