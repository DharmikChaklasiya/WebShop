$(document).ready(function ()
{
    $(".showDetails").click(function ()
	{        
        var user = $(this).attr('name');
        //alert(user);

        $.ajax(
		{
            url:'./php/showOrderDetails.php',
            type:'GET',
            data:
            {
                showDet: user
            },  
            error: function (response)
			{
                alert("Data not updated:" + response);
            },
            success: function (response)
			{  
                //alert("Data updated successfully: " + response);  
                $("#detResult").html(response);  
            } 
        });
    });
});             
