$(document).ready(function ()
{
    $(".inactiveChecked").click(function ()
	{
        
        var state = $(this).is(':checked'); // gets if checkbox is checked or not
        var user = $(this).val();
        alert(user);
        if (state)
        {
            isActive = 0;
        }
        else
        {
            isActive = 1;
        }

        $.ajax({
            url:'./php/changeStatus.php',
            type:'GET',
            data:
            {
                changeStatus: user,
                userStatus: isActive
            },
            success: function (response)
			{  
				//alert("Data updated successfully: " + response);  
                if (response != 0)
				{  
                    location.reload();  
                }  
            },  
            error: function (response)
			{  
                //alert("Data not updated: " + response);  
            } 
        });
    });
}); 

    