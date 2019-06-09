export let template = 
'<div class="w3-content w3-padding gg-width" id="camagru">\
  <h3 id="camagruBtn" class="w3-border-bottom w3-border-light-grey w3-padding">\
    <a class="w3-button" type="button" href="#camagru">\
      Camagru\
    </a>\
  </h3>\
	<section class="w3-container w3-center" style="max-width:1024px;margin:auto">\
		<div class="w3-row" id="filter">\
			<button id="btn_filter" class="w3-button w3-black w3-col s6 m3">\
				<p>filter</p>\
			</button>\
		</div>\
		<div class="">\
			<div id="">\
				<video id="video" poster="" width="100%" autoplay></video>\
				<img class="w3-hide" width="100%" id="filtertitle" src="filterurl">\
			</div>\
			<button id="snap" class="w3-button w3-red">Snap Photo</button>\
			<form method="post" action="">\
				<input type="file" class="w3-input" id="file" accept=".png"/>\
			</form>\
			<div id="prev">\
			</div>\
		</div>\
	</section>\
</div>'
