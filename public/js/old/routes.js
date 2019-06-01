'use strict'

export function listPics (status, json) {
  let btn

  if (json['pics'].length !== 0) {
    var child = createNode('div', { class: 'w3-hide' })
    var box = document.getElementById('carroussel')

    json['pics'].forEach(function (item) {
      var node = picDivFactory(item)

      node.setAttribute('onclick', "window.location.href='/picture/" + item['id'] + "'")
      child.appendChild(node)
    })
    box.appendChild(child)
    if (box.children.length === 1) {
      btn = document.getElementById('carrousselBtn')

      btn.removeAttribute('onload')
      ggCarroussel(btn, parseInt(json['start']) - 1, json['url'])
    }
  } else {
    btn = document.getElementById('carrousselBtn')

    btn.setAttribute('onclick', "ggCarroussel(this, 1, '" + json['url'] + "');")
  }
}

function addComment (status, json) {
  var comments = document.getElementById('comments')
  var first = commentDivFactory(json)

  comments.insertBefore(first, comments.firstChild)
}

function addPic (status, json) {
  var main = document.getElementById('new')
  var first = picDivFactory(json)
  var path = json['path']

  first.setAttribute('onclick', "if (confirm('Do you really want to delete this pictures?')){ggAjax('url=" + path + "', '/deletePic', deletePic)}")
  main.insertBefore(first, main.firstChild)
}

function deletePic (status, json) {
  var childNode = document.getElementById(json['url'])
  var parentNode = document.getElementById('new')

  parentNode.removeChild(childNode)
}

function addLike (status, json) {
  document.getElementById('like').textContent = json['likes_counter'] + ' likes'
  document.getElementById('likeButton').style.display = 'none'
}
