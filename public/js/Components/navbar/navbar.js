export function navbar () {
  let logBtnG = document.getElementById('logBtnG')
  let authForm = document.getElementById('form')
  let closeBtn = document.getElementById('closeBtn')

  function init () {
    logBtnG.addEventListener('click', openForm)
    closeBtn.addEventListener('click', closeForm)
  }

  function openForm () {
    authForm.style.display = 'block'
  }

  function closeForm () {
    authForm.style.display = 'none'
  }

  init()
}
