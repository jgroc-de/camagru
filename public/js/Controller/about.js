export class Contact {
  constructor () {
    this.section = document.getElementById('about')
    this.link = this.section.children[0].children[0]
  }

  view() {
    let link = this.link.href.split("#").pop()

    this.section.children[1].toggleAttribute('hidden')
    if (link === "about") {
      this.link.href = "#"
    } else {
      this.link.href = "#about"
    }
  }
}
