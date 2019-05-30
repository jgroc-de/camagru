"use strict";

function formManager()
{
	let forms = document.getElementsByTagName('form');

  function init() {
    setValidator()
  }

  function setValidator() {
    for (let form of forms) {
      let buttons = form.getElementsByTagName('button')

      for (let button of buttons) {
        if (button.type === 'submit') {
          button.addEventListener('click', submit)
          break
        }
      }
    }
  }

  function submit(event) {
    event.preventDefault()
    event.stopPropagation()
    validation(this)
  }

  function validation(button) {
    let form = button.parentNode.parentNode
    let data = {}

    for (let i = 0; i < form.length - 1; i++) {
      if (form[i].type !== 'checkbox' || form[i].checked === true) {
        data.pseudo = form[0].value
        data.password = form[1].value
        //data += form[i].name + "=" + form[i].value
      }
    }
    console.log(data)
    ggAjax(JSON.stringify(data), form)
  }

  init()
}

function ggAjax(data, form, callback) {
  let xmlhttp = new XMLHttpRequest()

  xmlhttp.open(form.method, form.action, true)
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4) {
      let json = JSON.parse(this.responseText)

      if (json['flash']) {
        printNotif(json['flash'], this.status)
      }
      if (callback && this.status == 200) {
        callback(this.status, json)
      }
    }
  }
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
  xmlhttp.send(data)
}

function printNotif(str, status) {
    let p = document.createElement('p')
    let div = createNode('div', {class:"w3-panel w3-round"})
    let notif = document.getElementById('notif')

    p.textContent = str
    div.style.margin = "0"
    div.appendChild(p)
    if (status == 200)
        div.classList.add('w3-green')
    else
        div.classList.add('w3-red')
    notif.appendChild(div)

    setTimeout(function() {notif.removeChild(div);}, 4500, notif, div)
}
