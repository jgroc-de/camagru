export class Index {
  constructor (state) {
    this.state = state
  }

  wakeUp () {
    for (let i in this.state.components) {
      this.state.components[i].shutDown()
    }
  }

  shutDown () {
  }
}
