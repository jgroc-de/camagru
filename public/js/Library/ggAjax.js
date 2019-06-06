import { printNotif } from './printnotif.js'

export function ggAjax (data, form, objet) {
  let request = new XMLHttpRequest()

  request.open(form.method, form.action, true)
  request.onreadystatechange = function () {
    if (this.readyState === 4) {
      let json = JSON.parse(this.responseText)

      if (json['flash']) {
        printNotif(json['flash'], this.status)
      }
      if (objet && this.status === 200) {
        objet.callback(json)
      }
    }
  }
  // Make the request
  request.setRequestHeader('Content-type', 'application/json')
  request.send(data)
}
