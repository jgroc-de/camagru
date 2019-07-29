import { ggAjax } from '../../../Library/ggAjax.js'

export class Logout {
	constructor (state) {
		this.state = state
		this.logBtnG = document.getElementById('logBtnG')
		this.form = {
			method: 'delete',
			url: state.url + '/login',
			body: {},
			checkValidity () { return true },
		}
	}

	wakeUp () {
		ggAjax(this.form, this)
	}

	shutDown () {
	}

	callback (response) {
    this.state.destroyLogin()
		if (this.state.components['Settings'])
			delete this.state.components['Settings']
    this.logBtnG.href = '#login'
    this.logBtnG.className = "w3-bar-item w3-green w3-button"
    window.location.assign('/')
  }
}
