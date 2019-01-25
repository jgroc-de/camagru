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
			if (callback && status == 200)
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

function ft_scroll(element)
{
	if (element.scrollTop > 350) {
		alert('lol');
	}
}
