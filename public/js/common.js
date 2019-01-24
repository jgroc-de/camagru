"use strict";

function ggForm(button, url, callback = null)
{
	var data = '';
	if (button)
	{
		var input = button.parentNode.parentNode;

		for (var i = 0; i < input.length - 1; i++)
		{
			if (input[i] != '')
				data += '&';

			if (!input[i].validity.valid)
			{
				printNotif(input[i].name + ': ' +input[i].validationMessage, 400);
				return ;
			}
			data += input[i].name + "=" + input[i].value;
		}
	}
	ggAjax(data, url, callback);
}

function ggAjax(data, url, callback)
{
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("POST", url, true);
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4)
		{
			var json = JSON.parse(this.responseText);

			if (json['flash'])
			{
				printNotif(json['flash'], this.status);
			}
			if (callback)
			{
				callback(this.status, json);
			}
		}
    };
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(data);
}

function printNotif(str, status)
{
    var p = document.createElement('p');
    var div = document.createElement('div');
    var notif = document.getElementById('notif');

    p.textContent = str;
    div.appendChild(p);
    div.className = "w3-panel w3-round";
    if (status == 200)
        div.classList.add('w3-green');
    else
        div.classList.add('w3-red');
    div.style.margin = "0";
    notif.appendChild(div);

    setTimeout(function() {notif.removeChild(div);}, 4500, notif, div);
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
	var form = document.getElementById('settings').getElementsByTagName("form");
	var settings = json['settings'];

	form[0][0].value = settings['pseudo'];
	form[0][1].value = settings['email'];
	form[0][2].setAttribute('checked', settings['alert']);
}

function ft_scroll(element)
{
	if (element.scrollTop > 350) {
		alert('lol');
	}
}
