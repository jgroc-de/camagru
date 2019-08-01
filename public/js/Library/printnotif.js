function createNode (type, attributes) {
	var node = document.createElement(type)

	for (var property in attributes) {
		node.setAttribute(property, attributes[property])
	}

	return node
}

export function printNotif (str, status) {
	let p = document.createElement('p')
	let div = createNode('div', { class: 'w3-panel w3-round' })
	let notif = document.getElementById('notif')

	p.textContent = str
	div.style.margin = '0'
	div.appendChild(p)
	if (status < 400) {
    div.classList.add('w3-green')
  } else {
    div.classList.add('w3-red')
  }
	notif.appendChild(div)

	setTimeout(function () {
    notif.removeChild(div)
  }, 4500, notif, div)
}
