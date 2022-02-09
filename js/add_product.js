function add_product (i_product, i_price)
{
	var count = parseInt($("#navButtonCart").val());
	if (isNaN(count))
	{
		count = 0;
	}
	
	$.ajax(
	{
		type: "POST",
		//url: "php/add_product.php",
		url: window.location.pathname,
		data: 
		{
			action: "add_to_cart",
			product: i_product,
			price: i_price
		},
		success: function (data)
		{
			//alert( "success: " + data);
			count++;
			$("#navButtonCart").val(count);
			$("#navButtonCart").text("Cart (" + count + ")");
		},
		error: function (data)
		{
			//alert( "error: " + data);
		}
	})/*.done(function( msg )
	{
		//alert( "Done stuff! msg: " + msg);
	});*/
};