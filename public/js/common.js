"use strict";

function ggForm(button, url, callback = null)
{
	var input = button.parentNode.parentNode;
	var data = '';

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
	ggAjax(data, url, callback);
}

function ggAjax(data, url, callback)
{
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("POST", url, true);
    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState == 4)
		{
            printNotif(this.responseText, this.status);
			if (callback)
				callback(this.status);
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

function login(status)
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
		logout.setAttribute('onclick', "ggForm(this, '/logout', logout)");
	}
}

function logout(status)
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
		camagru.setAttribute('onclick', "document.getElementById('form').style.display='block'");
	}
}
