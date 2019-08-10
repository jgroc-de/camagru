import { ggAjax } from '../../Library/ggAjax.js'

export class Logout {
	constructor (name, state) {
		this.state = state
		this.form = {
			method: 'delete',
			url: state.url + '/login',
			body: {},
			checkValidity () { return true },
		}
	}

  init() {
		this.logBtnG = document.getElementById('logBtnG')
  }

	run(test = true) {
    if (!test) {
		  ggAjax(this.form, this)
    }
	}

	callback (response) {
    this.state.destroyLogin()
		if (this.state.components['Settings'])
			delete this.state.components['Settings']
    this.logBtnG.href = '#login'
    this.logBtnG.className = "w3-bar-item w3-green w3-button"
    window.location.assign('/#')
  }
}

