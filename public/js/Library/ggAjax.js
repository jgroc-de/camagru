export function ggAjax (request, objet, async = true) {
	let XHR = new XMLHttpRequest()
	let json = JSON.stringify(request.body)

	XHR.open(request.method.toUpperCase(), request.url, async)
	XHR.onreadystatechange = function () {
    if (this.readyState === 4) {
      try {
        let json = JSON.parse(this.responseText)

        if (objet && objet.callback) {
          objet.callback(json, this.status)
        }
      } catch(error) {
        console.log("ggAjax")
        console.log(error)
      }
		}
	}
	XHR.setRequestHeader('Content-type', 'application/json')
	//if method is get, no json will be send
	XHR.send(json)
}
