export function burger () {
  let h3 = document.getElementsByTagName('h3')
  let nav = document.getElementById('pageNav')

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
