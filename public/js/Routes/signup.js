class SignUpRoute {
  constructor() {
    this.section = document.getElementById('signup')
    this.form = this.section.getElementsByTagName('form')[0]
    this.data = {
      pseudo:'',
      password:'',
      email:'',
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
    this.data.email = this.form[2].value
  }

  sendData() {
    ggAjax(JSON.stringify(this.data), this.form)
  }
}
