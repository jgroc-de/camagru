class LogoutRoute {
  constructor() {
    this.button = document.getElementById('logBtnB')
    this.logBtnG = document.getElementById('logBtnG')
    this.logBtnB = this.button
    this.form = {
      method:'delete',
      action:'localhost:8888/logout',
      checkValidity() {return true}
    }
  }

  setData() {
  }

  sendData() {
    ggAjax('', this.form, this)
  }

  callback(response) {
    logBtnG.toggleAttribute('hidden')
    logBtnB.toggleAttribute('hidden')
  }
}

