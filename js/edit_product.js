$(document).ready(function ()
{
    $(".img-responsive").click(function ()
	{        
        var imgName = $(this).attr('title');
        //alert(imgName);

        $.ajax({
            url:'./php/product_edit.php',
            type:'GET',
            data:
            {
                productName: imgName
            },
            success: function (data)
			{
                $("#resultsEditProduct").html(data);  
            } 
        });
    });
}); 