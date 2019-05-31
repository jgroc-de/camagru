class LoginRoute {
  constructor() {
    this.section = document.getElementById('login')
    this.form = document.getElementsByTagName('form')[0]
    this.data = {
      pseudo:'',
      password:''
    }
  }

  setData() {
    this.data.pseudo = this.form[0].value
    this.data.password = this.form[1].value
  }

  sendData() {
    ggAjax(JSON.stringify(this.data), this.form, this.action)
  }

  action() {
    console.log('login')
  }
}
