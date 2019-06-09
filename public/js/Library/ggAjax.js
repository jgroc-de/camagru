import { printNotif } from './printnotif.js'

export function ggAjax (request, objet) {
  let XHR = new XMLHttpRequest()

  XHR.open(request.method.toUpperCase(), request.url, true)
  XHR.onreadystatechange = function () {
    if (this.readyState === 4) {
      let json = JSON.parse(this.responseText)

      if (json['flash']) {
        printNotif(json['flash'], this.status)
      }
      if (objet && objet.callback && this.status === 200) {
        objet.callback(json)
      }
    }
  }
  XHR.setRequestHeader('Content-type', 'application/json')
  XHR.send(JSON.stringify(request.body))
}
