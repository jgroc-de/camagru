"use strict";

function addComment(id)
{
    var xmlhttp = new XMLHttpRequest();
    var text = document.getElementsByClassName('text')[0];
    var warning = document.getElementById('lol');

    if (text.value !== "")
    {
        var data = "id=" + id + "&text=" + text.value;

        xmlhttp.open("POST", "index.php?action=addComment", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            {
                document.getElementsByClassName("comment")[0].insertAdjacentHTML("afterbegin", '<div>' + this.responseText + '</div>');
            }
        };
        warning.innerHTML = "";
        text.value = "";
        xmlhttp.send(data);
    }
    else
    {
        warning.textContent = "faut écrire une bafouille!!";
        warning.style.backgroundColor = "#f9ccca";
    }
}

function changeTitle(id) {
    var emNode = document.getElementsByTagName('em')[0];

    emNode.setAttribute('contenteditable', 'true');
    emNode.addEventListener("blur", function () {
        var title = emNode.textContent;

        if (title && title.length < 30) {
            var xmlhttp = new XMLHttpRequest();
        
            xmlhttp.open("GET", "index?action=changeTitle&q=" + id + "&title=" + title, true);
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    emNode.textContent = this.responseText;
                }
            };
            xmlhttp.send();
        } else {
            alert("lol, c'est trop (> 30) ou NULL");
            if (!title) {
                document.emNode.textContent = "lol";
            }
        }
    });
}
