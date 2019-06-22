export function ggAjax (request, objet, async = true) {
	let XHR = new XMLHttpRequest()
	let json = JSON.stringify(request.body)

	XHR.open(request.method.toUpperCase(), request.url, async)
	XHR.onreadystatechange = function () {
		if (this.readyState === 4) {
			let json = JSON.parse(this.responseText)

			if (objet && objet.callback && this.status === 200) {
				objet.callback(json, this.status)
			}
		}
	}
	XHR.setRequestHeader('Content-type', 'application/json')
	//if method is get, no json will be send
	XHR.send(json)
}
