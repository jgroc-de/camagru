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
			if (callback && this.status == 200)
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

function picDivFactory(json)
{
	var first = document.createElement('div');
	var second = document.createElement('div');
	var title = document.createElement('div');
   	var img = document.createElement('img');
	var path = json['path'];

	first.setAttribute('class', "w3-col l3 m6 w3-margin-bottom");
	second.setAttribute('class', "w3-display-container");
	title.setAttribute('class', "w3-display-topleft w3-black w3-padding");
	title.innerHTML = path;
	img.style = "width:100%";
	img.src = path;
	img.alt = path;
	img.title = path;
	first.id = path;
	second.appendChild(title);
	second.appendChild(img);
	first.appendChild(second);
	return first;
}

function commentDivFactory(json)
{
	var first = document.createElement('div');
	var comment = document.createElement('p');
	var title = document.createElement('h3');
	var span = document.createElement('span');
	var date = new Date(json['date2']);
	var options = {hour12: true, year: "numeric", month: "long", day: "numeric", hour: "2-digit", minute: "2-digit"};

	first.setAttribute('class', "w3-row w3-margin-bottom");
	span.setAttribute('class', "w3-opacity w3-medium");
	comment.style.wordWrap = "break-Word";
	comment.innerHTML = json['content'];
	title.innerHTML = json['pseudo'] + ' ';
	span.innerHTML = 'on ' + date.toLocaleString('en-GB', options); 
	title.appendChild(span);
	first.appendChild(title);
	first.appendChild(comment);
	return first;
}

function validTitle(str)
{
	if (!str || str.length == 0)
	{
		printNotif("can't be empty", 400);
	}
	else if (str.length > 30)
	{
		printNotif("too long", 400);
	}
	else
	{
		ggAjax(str, '/changeTitle');
	}
}
