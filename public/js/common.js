"use strict";

function ggForm(button, url, callback = null)
{
	var data = '';
	if (button)
	{
		var input = button.parentNode.parentNode;

		for (var i = 0; i < input.length - 1; i++)
		{
			if (!input[i].validity.valid)
			{
				printNotif(input[i].name + ': ' +input[i].validationMessage, 400);
				return ;
			}
			if (input[i].type !== 'checkbox' || input[i].checked === true)
			{
				data += '&';
				data += input[i].name + "=" + input[i].value;
			}
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
    var div = createNode('div', {class:"w3-panel w3-round"});
    var notif = document.getElementById('notif');

    p.textContent = str;
    div.style.margin = "0";
    div.appendChild(p);
    if (status == 200)
        div.classList.add('w3-green');
    else
        div.classList.add('w3-red');
    notif.appendChild(div);

    setTimeout(function() {notif.removeChild(div);}, 4500, notif, div);
}

function createNode(type, attributes)
{
	var node = document.createElement(type);

	for (var property in attributes)
	{
		node.setAttribute(property, attributes[property]);
	}
	return node;
}

function picDivFactory(json)
{
	var path = json['path'];
	var first = createNode('div', {
		class:'w3-col l3 m6 w3-margin-bottom w3-button',
		id:path,
	});
	var second = createNode('div', {
		class:"w3-display-container",
	});
	var title = createNode('div', {
		class:"w3-display-topleft w3-black w3-padding",
	});
   	var img = createNode('img', {
		width:"100%",
		src:path,
		alt:path,
		title:path
	});

	title.textContent = json['title'];
	second.appendChild(title);
	second.appendChild(img);
	first.appendChild(second);
	return first;
}

function commentDivFactory(json)
{
	var date = new Date(json['date2']);
	var first = createNode('div', {
		class:"w3-row w3-margin-bottom",
	});
	var span = createNode('span', {
		class:"w3-opacity w3-medium",
	});
	var comment = document.createElement('p');
	var title = document.createElement('h3');

	comment.style.wordWrap = "break-Word";
	comment.textContent = json['content'];
	title.textContent = json['pseudo'] + ' ';
	span.textContent = 'on ' + date.toLocaleString('en-GB', {hour12: true, year: "numeric", month: "long", day: "numeric", hour: "2-digit", minute: "2-digit"});
	title.appendChild(span);
	first.appendChild(title);
	first.appendChild(comment);
	return first;
}

function ggDestroy(button, id, url)
{
	var box = document.getElementById(id);
	var childs = button.parentNode.children;

	while (box.firstChild)
	{
    	box.removeChild(box.firstChild);
	}
	for (var i = 0; i < childs.length; i++)
	{
		childs[i].removeAttribute('disabled');
	}
	button.setAttribute('disabled', "");
	ggAjax('&start=1', url, listPics);
	ggAjax('&start=2', url, listPics);
	ggAjax('&start=3', url, listPics);
}

function ft_scroll(element)
{
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
