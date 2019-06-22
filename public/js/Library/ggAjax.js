export function ggAjax (request, objet, async = true) {
	let XHR = new XMLHttpRequest()

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
	XHR.send(JSON.stringify(request.body))
}
