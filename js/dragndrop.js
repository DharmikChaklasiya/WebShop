// Functions for drag and drop
function allowDrop (ev)
{
    ev.preventDefault();
}

function drag (ev)
{
	//alert("event target stuff:\r\nalt:" + ev.target.alt);
	ev.dataTransfer.setData("text", ev.target.id);
	ev.dataTransfer.setData("alt", ev.target.alt);
	//ev.dataTransfer.setData("price", ev.target.childNodes[0]);
	//var div = ev.target.nextSibling;
	var div = ev.target.nextElementSibling; // the div containing all informations
	
	//var input = div.getElementsByName("price");
	for (var i = 0; i < div.childNodes.length; i++) // get price element
	{
		if (div.childNodes[i].name == "price")
		{
			ev.dataTransfer.setData("price", div.childNodes[i].value);
			break;
		}        
	}
}

function drop (ev)
{
    ev.preventDefault();	
	//javascript:add_product('$name','".$product['price']."')"; ?>>
	add_product(ev.dataTransfer.getData("alt"), ev.dataTransfer.getData("price"));
}
