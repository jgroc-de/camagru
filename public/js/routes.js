'use strict';

function listPics(status, json)
{
	var box = document.getElementById('carroussel');

	json['pics'].forEach(function(item) {
		var node = picDivFactory(item);

		node.setAttribute("onclick", "window.location.href='/picture/"+item['id']+"'");
		box.appendChild(node);
	});
}

function addComment(status, json)
{
	var comments = document.getElementById("comments");
	var first = commentDivFactory(json);

	comments.insertBefore(first, comments.firstChild);
}

function addPic(status, json)
{
	var main = document.getElementById('new');
	var first = picDivFactory(json);
	var path = json['path'];

	first.setAttribute('onclick', "if (confirm('Voulez Vous vraiment supprimer cette image?')){ggAjax('url=" + path + "', '/deletePic', deletePic)}");
	main.insertBefore(first, main.firstChild);
}

function deletePic(status, json)
{
	var childNode = document.getElementById(json['url']);
	var parentNode = document.getElementById('new');

	parentNode.removeChild(childNode);
}

function addLike(status, json)
{
	document.getElementById("like").textContent = json['likes_counter'] + ' likes';
	document.getElementById("likeButton").style.display = 'none';
}

function login(status, json)
{
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

function logout(status, json)
{
	var camagru = document.getElementById("btnCamagru");
	var settings = document.getElementById("btnSettings");
	var logout = document.getElementById("btnLog");

	settings.style.display = 'none';
	logout.className = "w3-bar-item w3-green w3-button";
	logout.removeAttribute('onclick');
	logout.setAttribute('onclick', "document.getElementById('form').style.display='block'");
	camagru.href = "#camagru";
	camagru.setAttribute('onclick', "document.getElementById('form').style.display='block'");
}

function fillSettings(status, json)
{
	var form = document.getElementById('settings').getElementsByTagName("form");
	var settings = json['settings'];

	form[0][0].value = settings['pseudo'];
	form[0][1].value = settings['email'];
	form[0][2].setAttribute('checked', settings['alert']);
}
