'use strict'

function app() {
  function init() {
    components()
    routes()
  }

  function navbar() {
    burger()
    loginForms()
  }

  function routes() {
    const login = new LoginRoute()

    formManager(login)
  }

  function components() {
    navbar()
  }

  init()
}

app()
