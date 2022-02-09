function generateVoucher ()
{
	$.ajax(
	{
		type: "POST",
		url: "php/generate_vouchers.php",
		data: 
		{
			value: $('#value').val(),
			code: $('#code').val(),
			date: $('#date').val()
		},
		success: function (data)
		{
			//$('#code').val(data); // either reload all or put into html
			location.reload();
		}
	})
};