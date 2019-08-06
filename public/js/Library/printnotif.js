function createDiv(str, status) {
	let div = document.createElement("div")
	let p = document.createElement('p')

	p.textContent = str
	div.appendChild(p)
  div.classList.add('w3-panel')
  div.classList.add('w3-round')
	div.style.margin = '0'
	if (status < 400) {
    div.classList.add('w3-green')
  } else {
    div.classList.add('w3-red')
  }

	return div
}

export function printNotif(str, status) {
	let div = createDiv(str, status)
	let notif = document.getElementById('notif')

	notif.appendChild(div)
	setTimeout(
    function () {
      notif.removeChild(div)
    },
    4500,
    notif,
    div
  )
}
