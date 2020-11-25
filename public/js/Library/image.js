function fetchImage(img, url) {
  img.src = url
  return
  /*if (window.fetch) {
    fetch(url)
      .then(function(response) {
        return response.blob();
      })
      .then(function(myBlob) {
        let objectURL = URL.createObjectURL(myBlob);
        img.src = objectURL;
      });
  } else {
    img.src = url
  }*/
}

export function getImage(img, data) {
  fetchImage(img, data.url)
  img.alt = data.title
  img.title = data.title

  return img;
}
