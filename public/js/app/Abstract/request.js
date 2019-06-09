export class request {
  constructor (inputs) {
    this.body = {}
    this.url = ''
    this.method = 'GET'
    this.setBody(inputs)
    this.setUrl(inputs)
    this.setMethod(inputs)
  }

  setBodyParam(input) {
    console.log(input)
    switch (input.type) {
      case 'checkbox':
        if (input.checked) {
          this.body[input.name] = 'true'
        }
        break
      case 'submit':
        break
      default:
        this.body[input.name] = input.value
    }
  }

  setBody(inputs) {
    let i = 0

    while (i < inputs.length) {
      this.setBodyParam(inputs[i++])
    }
  }

  setUrl(inputs) {
    this.url = inputs.action
  }

  setMethod(inputs) {
    this.method = inputs.attributes ? inputs.attributes["method"].value : inputs.method
  }
}
