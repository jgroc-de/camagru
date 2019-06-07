function burger () {
  let h3 = document.getElementsByTagName('h3')

  function init () {
    hide()
    document.getElementById('burger').addEventListener('click', pageNav)
    setBurger()
  }

  function hide () {
    for (let element of h3) {
      let nextSibling = element.nextElementSibling

      element.addEventListener('click', () => {
        nextSibling.toggleAttribute('hidden')
      })
    }
  }

  function pageNav () {
    nav.hidden = !nav.hidden
    this.classList.toggle('change')
  }

  function setBurger () {
    for (let i = 0; i < h3.length; i++) {
      nav.children[i].children[0].innerText = h3[i].innerText.toLowerCase()
      nav.children[i].addEventListener('click', () => {
        h3[i].nextElementSibling.hidden = false
      })
    }
  }

  init()
}

export class Burger {
  constructor (state) {
    this.state = state
    this.name = 'burger'
    this.link = document.getElementById(this.name)
    this.nav = document.getElementById('pageNav')
    this.settings = document.getElementById('btnSettings')
  }

  view(defaultView = false) {
    let link = this.link.href.split("#").pop()

    if (defaultView) {
        this.link.href = "#" + this.name
        this.nav.setAttribute('hidden', true)
    } else {
      this.nav.toggleAttribute('hidden')
      console.log(this.state.login)
      if (this.state.isLogin()) {
        this.settings.removeAttribute('hidden')
      } else {
        this.settings.setAttribute('hidden', true)
      }
      if (link === "") {
        this.link.href = "#" + this.name
      } else {
        this.link.href = "#"
      }
    }

    return false
  }

  wakeUp () {
    return this.view()
  }

  shutDown () {
    return this.view(true)
  }
}
