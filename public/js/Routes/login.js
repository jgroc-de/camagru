class LoginRoute {
  constructor() {
    this.logBtnG = document.getElementById('logBtnG')
    this.section = document.getElementById('login')
    this.form = this.section.getElementsByTagName('form')[0]
    this.data = {
      pseudo:'',
      password:''
    }
    let buttons = form.getElementsByTagName('button')

    for (let button of buttons) {
      if (button.type === 'submit') {
        this.button = button
        break
      }
    }
  }

  setData() {
    this.data.pseudo = this.form[0].value
    this.data.password = this.form[1].value
  }

  sendData() {
    ggAjax(JSON.stringify(this.data), this.form, this)
  }

  callback(response) {
    logBtnG.toggleAttribute('hidden')
    logBtnB.toggleAttribute('hidden')
  }
}
