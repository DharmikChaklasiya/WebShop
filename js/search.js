//Function for the live search

$(document).ready(function () {
	$("#searchInput").on('keyup',function () {
		var key = $(this).val();
		//alert("js works");
		//To hide exists products in category if search begins
		var x = document.getElementsByClassName('hide_prods');

		if(key == '')
		{
			for (i = 0; i < x.length; i++) 
			{
				x[i].style.display = "block";
			}
		}
		else
		{
			for (i = 0; i < x.length; i++) 
			{
				x[i].style.display = "none";
			}
		}

		//send the keyword which was entered
		$.ajax({
			url:'./php/products_search.php',
			type:'GET',
			data:'keyword='+key,
			success:function (data) {
				$("#results").html(data);
			}
		});
	});
});
