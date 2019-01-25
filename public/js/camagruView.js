'use strict';

play();
(function()
 {   
    var allowedTypes = ['png'];
    var fileInput = document.getElementById('file');
    var preview = document.getElementById('miseEnPage');
    var buton = document.getElementById("snap");

    fileInput.addEventListener('change', function()
    {    
        var files = this.files, imgType;
       
        imgType = files[0].name.split('.');
        imgType = imgType[1].toLowerCase();
        if (allowedTypes.indexOf(imgType) != -1) {
            snap();
            createThumbnail(files[0]);
        }
    });
})();

function display(filter)
{
    var preview = document.getElementById(filter);
    var btn = document.getElementById('btn_' + filter);

    if (filter === undefined)
        filter = "troll";
    if (preview.style.visibility === "visible")
    {
        btn.style.boxShadow = "0px 0px 0px 0px";
        preview.style.visibility = "hidden";
        preview.alt = "hidden";
    }
    else
    {
        btn.style.boxShadow = "0px 0px 5px 5px";
        preview.style.visibility = "visible";
        preview.alt = "visible";
    }
}

function createThumbnail(file)
{
    var reader = new FileReader();

    reader.addEventListener('load', function() {
        var imgElt = document.createElement('img');
        var refNode = document.getElementById('troll');
        var videoNode = document.getElementById('video');
        var oldNode = document.getElementById('upload');

        if (oldNode)
            preview.removeChild(oldNode);
        imgElt.src = this.result;
        imgElt.style.visibility = 'visible';
        imgElt.style.position = 'absolute';
        imgElt.style.left = 0;
        imgElt.id = 'upload';
        videoNode.style.visibility = 'hidden';
        preview.insertBefore(imgElt, refNode);
    });
    reader.readAsDataURL(file);
}

// Trigger photo take
function snap()
{
    var buttonSnap = document.getElementById('snap');

    buttonSnap.removeAttribute('onclick');
    if (typeof snap.on == 'undefined')
    {
        snap.on = 0;
        buttonSnap.addEventListener('click', function()
        {
            var canvas = document.getElementById('canvas');
            var context = canvas.getContext('2d');
            var	tabFilter = document.querySelectorAll('img[alt=visible]');
            var title = [];
            var upload = document.getElementById('upload');
            var i = 0;
            var dataUrl;

            if (upload) {
                dataUrl = upload.src;
            } else {
                context.drawImage(video, 0, 0, 640, 480);
                dataUrl = canvas.toDataURL('image/png');
            }
            while (tabFilter[i])
            {
                title.push(tabFilter[i++].id);
            }
            createPic(dataUrl, title);
            printNotif('On fait chauffer les hamsters, votre photo arrive!', 200);
        });
    }
}

function play()
{
	var video = document.getElementById('video');
    var button = document.getElementById('snap');

	if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
    {
		navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream)
        {
            snap();
			video.srcObject = stream;
			video.play();
		});
	}
}

function createPic(data, filter)
{
	var str = 'data=' + data;
	var i = 0;

	while (filter[i])
    {
		str += '&title' + i + '=' + filter[i];
		i++;
	}
	ggAjax(str, '/createPic', addPic);
}

