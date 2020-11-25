export class Error {
		constructor(name, state) {
				this.state = state
				this.hide = true
		}

		init() {
				this.intro = document.getElementById("intro")
				this.spans = intro.getElementsByTagName("span")
		}

		run(test) {
				if (!test && this.hide) {
						this.hide = !this.hide
						this.intro.style.height = "400px"
						document.body.classList.add("w3-sepia-max")
						this.spans[0].textContent = this.state.httpStatus
						this.spans[1].textContent = this.state.error
				} else if (!this.hide) {
						this.hide = !this.hide
						this.intro.removeAttribute("style")
						document.body.classList.remove("w3-sepia-max")
						this.spans[0].textContent = "GG"
						this.spans[1].textContent = "Camagru"
				}
		}
}
