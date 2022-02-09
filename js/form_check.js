// with "strip" we prevent the user to input invalid character Combinations
// although using "escapeString" from our DB Connection class assures us valid strings in DB


// need to escape HTML Tags:
// https://stackoverflow.com/questions/43249998/chrome-err-blocked-by-xss-auditor-details
// adding "ResponseHeader set X-XSS-Protection 0" to apache httpd.conf
// --> otherwise chrome blocks xxs
function strip (i_htmlElem)
{
	elem = document.getElementById(i_htmlElem);
	var tmp = document.createElement("DIV");
	//tmp.innerHTML = i_html;
	tmp.innerHTML = elem.value;
	//text = elem.value.replace(/<(?:.|\n)*?>/gm, '');
	text = tmp.textContent || tmp.innerText || "";
	//console.log("text: " + text);
	elem.value = text;
	
	//checkInput(); --> TODO: make nice dynamic ^^
}

function checkInput () 
{
	var name = document.forms["registrationForm"]["name"].value;
    if (name.length < 3 || name.length >20) 
	{
		document.forms["registrationForm"]["name"].style.border = "1px solid red";
        alert("Der Name muss 3 bis 20 Zeichen beinhalten");
        return false; // keep form from submitting
    } else 
	{  	
        document.forms["registrationForm"]["name"].style.border = "1px solid grey";
        var surname = document.forms["registrationForm"]["surname"].value;
        if (surname.length < 3 || surname.length >20) 
        {
            document.forms["registrationForm"]["surname"].style.border = "1px solid red";
            alert("Der Nachname muss 3 bis 20 Zeichen beinhalten");
            return false; // keep form from submitting
        } else
        {  	
            document.forms["registrationForm"]["surname"].style.border = "1px solid grey";
            var username = document.forms["registrationForm"]["user"].value;
            /*if (username.length < 3 || username.length >20) 
            {
                document.forms["registrationForm"]["user"].style.border = "1px solid red";
                alert("Der Username muss 3 bis 20 Zeichen beinhalten");
                return false; // keep form from submitting
            } else */
            {  	
                document.forms["registrationForm"]["name"].style.border = "1px solid grey";


                var pass = document.forms["registrationForm"]["password"].value;
                /*if (pass.length < 8) 
                {
                    document.forms["registrationForm"]["password"].style.border = "1px solid red";
                    alert("Das Password muss mindestens aus 8 Zeichen bestehen");
                    return false;
                } else 
                {			
                    if (pass.search(/[A-Z]/) < 0) 
                    {
                        document.forms["registrationForm"]["password"].style.border = "1px solid red";
                        alert("Das Password muss mindestens eine Großbuchstabe beinhalten");
                        return false;
                    } else 
                    {		
                        if (pass.search(/[0-9]/) < 0) 
                        {
                            document.forms["registrationForm"]["password"].style.border = "1px solid red";
                            alert("Das Password muss mindestens eine Zahl beinhalten");
                            return false;
                        } else
                        {
                            if (pass.search(/[ !"#$%&'()*+,-./:;<=>?@[\]^_`{|}~]/) < 0) 
                            {
                                document.forms["registrationForm"]["password"].style.border = "1px solid red";
                                alert("Das Password muss mindestens ein Sonderzeichen beinhalten");
                                return false;
                            } else	
                            { */ 	
                                document.forms["registrationForm"]["password"].style.border = "1px solid grey";
                                                           
                                var email = document.forms["registrationForm"]["email"].value;
                                if (email.search(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/) != 0) 
                                {
                                    document.forms["registrationForm"]["email"].style.border = "1px solid red";
                                    alert("Die E-Mail Adresse ist nicht korrekt");
                                    return false;
                                } else	
                                {  	
                                    document.forms["registrationForm"]["email"].style.border = "1px solid grey";
                                    return true;								
                                }                                
                            /*}
                        }
                    }
                }*/
            }
        }    
    }
}

$(document).ready(function ()
{
	$('#value').on('input', function(e)
	{
		if ($('#value').val().length > 3)
		{
			$('#value').val($('#value').val().slice(0, 3));
		}
		$("#btnCreateVoucher").prop('disabled', $('#value').val().length == 0);
	});
	
	$('#inputVoucherCode').on('input', function(e)
	{
		if ($('#inputVoucherCode').val().length == 5)
		{
			// check if given code is valid and show
			$.ajax(
			{
				url:'./php/redeemVoucher.php',
				type:'POST',
				data:
				{
					action: "redeemVoucher",
					code: $('#inputVoucherCode').val()
				},  
				error: function (response)
				{
					alert("Data not updated:" + response);
				},
				success: function (response)
				{  
					//alert("Data updated successfully: " + response);
					$('#divVoucherValue').val(response);
				} 
			});
		}
	});
	
	$('input.registrationInput').on('input', function(e)
	{
		val = false;
		$( ".registrationInput" ).each(function()
		{
			if ($(this).val().length == 0)
			{
				val = true;
				return;
			}
		});
		$("#btnCreateAccount").prop('disabled', val);
	});
	
	$('input.accountInput').on('input', function(e)
	{
		val = false;
		$( ".accountInput" ).each(function()
		{
			if ($(this).val().length == 0)
			{
				val = true;
				return;
			}
		});
		$("#submitUpdateData").prop('disabled', val);
	});
	
	$('input.cartPaymentOption').on('input', function(e)
	{
		val = false;
		$( ".cartPaymentOption" ).each(function()
		{
			if ($(this).is(":checked"))
			{
				val = true;
				return;
			}
		});
		$("#btnMakeOrder").prop('disabled', !val);
	});
});