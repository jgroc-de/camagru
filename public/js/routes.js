'use strict';

function addPic(status, json)
{
	var first = document.createElement('div');
	var second = document.createElement('div');
	var title = document.createElement('div');
   	var img = document.createElement('img');
	var main = document.getElementById('new');
	var path = json['path']

	first.setAttribute('class', "w3-col l3 m6 w3-margin-bottom");
	second.setAttribute('class', "w3-display-container");
	title.setAttribute('class', "w3-display-topleft w3-black w3-padding");
	title.innerHTML = path;
	img.style = "width:100%";
	img.src = path;
	img.alt = path;
	img.title = path;
	first.id = path;
	first.setAttribute('onclick', "if (confirm('Voulez Vous vraiment supprimer cette image?')){ggAjax('" + path + "', '/deletePic', deletePic)}");
	second.appendChild(title);
	second.appendChild(img);
	first.appendChild(second);
	main.insertBefore(first, main.firstChild);
}

function deletePic(status, json)
{
	if (status == 200)
	{
		var childNode = document.getElementById(json['url']);
		var parentNode = document.getElementById('new');

		parentNode.removeChild(childNode);
	}
}

function addLike(status, json)
{
	if (status == 200)
	{
		document.getElementById("like").textContent = json['likes_counter'];
	}
}

function login(status, json)
{
	if (status == 200)
	{
		var form = document.getElementById("form");
		var camagru = document.getElementById("btnCamagru");
		var logout = document.getElementById("btnLog");
		var settings = document.getElementById("btnSettings");

		form.style.display = 'none';
		settings.style.display = 'block';
		logout.className = "w3-bar-item w3-black w3-button";
		logout.removeAttribute('onclick');
		camagru.removeAttribute('onclick');
		camagru.href = "/camagru";
		logout.setAttribute('onclick', "ggForm(this, '/logout', logout)");
	}
}

function logout(status, json)
{
	if (status == 200)
	{
		var logout = document.getElementById("btnLog");
		var camagru = document.getElementById("btnCamagru");
		var settings = document.getElementById("btnSettings");

		settings.style.display = 'none';
		logout.className = "w3-bar-item w3-green w3-button";
		logout.removeAttribute('onclick');
		logout.setAttribute('onclick', "document.getElementById('form').style.display='block'");
		camagru.href = "#camagru";
		camagru.setAttribute('onclick', "document.getElementById('form').style.display='block'");
	}
}

function fillSettings(status, json)
{
	if (status == 200)
	{
		var form = document.getElementById('settings').getElementsByTagName("form");
		var settings = json['settings'];

		form[0][0].value = settings['pseudo'];
		form[0][1].value = settings['email'];
		form[0][2].setAttribute('checked', settings['alert']);
	}
}
