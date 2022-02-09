var dropbox = document.getElementById('dropbox');

function init ()
{
	if (dropbox)
	{
		dropbox.addEventListener('dragenter', noopHandler, false);
		dropbox.addEventListener('dragleave', noopHandler, false);
		dropbox.addEventListener('dragexit', noopHandler, false);
		dropbox.addEventListener('dragover', noopHandler, false);
		dropbox.addEventListener('drop', drop, false);
	}
}

function noopHandler (evt)
{
	evt.stopPropagation();
	evt.preventDefault();   
	if (evt.type != "dragexit" && evt.type != "dragleave")
	{
		dropbox.style.backgroundColor = "Gray";
	}
	else
	{
		dropbox.style.backgroundColor = "White";
	}
}   

function drop (evt)
{
	dropbox.style.backgroundColor = "White";
	evt.stopPropagation();
	evt.preventDefault();
	var files = evt.dataTransfer.files;
	var count = files.length; 
	for (i = 0; i < count; i++)
	{
		var formData = new FormData();
		formData.append("file", files[i]);

		var newRequest = new XMLHttpRequest();
		//newRequest.open("POST", "php/upload_ajax.php", true);
		//newRequest.open("POST", "php/products.php", true);
		newRequest.open("POST", "index.php?section=Products", true);
		//newRequest.open("POST", ".", true);
		newRequest.addEventListener("load", transferComplete, false);
		newRequest.send(formData);
		
		/* alternative per ajax:
		$.ajax(
		{
			type: "POST",
			data: formData,
			url: "upload_ajax.php",
			cache: false,
			contentType: false,
			processData: false,
			success: transferComplete
		});*/
	}
}         

function transferComplete (evt)
{
	console.log(evt.target.responseText);
	//var result = document.getElementById('result'); 
	//result.innerHTML = evt.target.responseText;
	//window.location.replace("index.php?section=Products");
	//window.location.replace(evt.target.responseText);
}
/*
function uploadFromDropZone ()
{
	var dropzone = document.getElementById("dropzone");
	dropzone.processQueue();
}

$('#uploadBut').click(function() 
{
	var myDropzone = Dropzone.forElement(".dropzone");
	// if myDropzone.hasData -> processQueue
	myDropzone.processQueue(); 
	//else // -> call form post
	location.reload();
});*/

