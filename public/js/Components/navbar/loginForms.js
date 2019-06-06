export function loginForms () {
  let views
  let btns

  function init () {
    views = getFormViews()
    btns = getFormBtns()

    setBtnsEvent(btns)
    views[0].toggleAttribute('hidden')
  }

  function deactive () {
    for (let btn of btns) {
      btn.classList = 'w3-button w3-section gg-post-it'
    }
  }

  function activate (element) {
    element.classList = 'w3-button w3-section w3-grey gg-post-it'
  }

  function hide () {
    for (let view of views) {
      view.setAttribute('hidden', '')
    }
  }

  function switchForm (element, view) {
    hide()
    deactive()
    activate(element)
    view.toggleAttribute('hidden')
  }

  function setBtnsEvent (btns) {
    let reinitBtnAlt = document.getElementById('reinitBtnAlt')

    for (let i = 0; i < btns.length; i++) {
      btns[i].addEventListener('click', () => {
        switchForm(btns[i], views[i])
      })
    }
    reinitBtnAlt.addEventListener('click', () => {
      switchForm(btns[2], views[2])
    })
  }

  function getFormViews () {
    let login = document.getElementById('login')
    let signup = document.getElementById('signup')
    let reinit = document.getElementById('reinit')

    return [login, signup, reinit]
  }

  function getFormBtns () {
    let reinitBtn = document.getElementById('reinitBtn')
    let signupBtn = document.getElementById('signupBtn')
    let loginBtn = document.getElementById('loginBtn')

    return [loginBtn, signupBtn, reinitBtn]
  }

  init()
}
