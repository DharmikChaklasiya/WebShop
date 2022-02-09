function delete_orderItem (i_item, i_id)
{
	if (confirm('Are you sure you want to delete ' + i_item + '?') == false)
	{
		return;
	}

	$.ajax({
		url:'./php/delete_item.php',
		type:'POST',
		data:
		{
			item: i_item,
			id: i_id
		},
		success: function (data)
		{
			//alert("success: " + data);
			location.reload();
		},
		error: function (data)
		{
			//alert("error: " + data);
		} 
	});
};