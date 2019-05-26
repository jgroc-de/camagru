'use strict';

function ggHide() {
  let h3 = document.getElementsByTagName('h3')

  for (let element of h3) {
    let nextSibling = element.nextElementSibling

    nextSibling.toggleAttribute('hidden')
    element.addEventListener('click', () => {
      nextSibling.toggleAttribute('hidden')
    }
    )
  }
}

function ggNavbar() {
}

function launch() {
  ggHide()
  ggNavbar()
  ggHome()
}

launch()
