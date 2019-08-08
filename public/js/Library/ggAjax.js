export function ggAjax (request, objet, async = true) {
	let XHR = new XMLHttpRequest()
	let json = JSON.stringify(request.body)

	XHR.open(request.method.toUpperCase(), request.url, async)
	XHR.onreadystatechange = function () {
    if (this.readyState === 4) {
      try {
        let json = JSON.parse(this.responseText)

        if (objet && objet.state && this.status > 399) {
          objet.state.httpStatus = this.status
          objet.state.error = this.statusText
        }
        if (this.status === 404) {
		      window.location.assign("#error")
        }
        if (objet && objet.callback) {
          objet.callback(json, this.status)
        }
      } catch(error) {
      }
		}
	}
	XHR.setRequestHeader('Content-type', 'application/json')
	//if method is get, no json will be send
	XHR.send(json)
}
