function add_to_cart(product_id, name, price)
    {
        var base_url = window.location.pathname;
        $.ajax({
            method: "POST",
            url: base_url,  // gibt aktuelle URL zurück
            data: {
                produktId: product_id,
                action: "add",
                type: "warenkorb",
                name: name,
                price: price
            },
            success: function(ret){
                $("#inCart").html(ret);
                aktualisiere_count();
            }
            //error? gibts bei mir nicht xD
        });
    }

/*function aktualisiere_count()
    {
        count = 0;
        $("#inCart .count_produkte").each(function(i,k){
            count += parseInt($(k).text());
        });
        if(count < 1){
            $(".warenkorb_count").hide();
        }else{
            $(".warenkorb_count").show();
        }
        $(".warenkorb_count").text(count);
    }

    function open_cart()
    {
        $("#warenkorb").addClass("open");
    }

    function close_cart()
    {
        $("#warenkorb").removeClass("open");
    }

    function cat_products(cat){
        $(".product_item").each(function(i,k){
            var id = $(k).attr("data-category-id");
            if($(k).attr("data-category-id") == cat){
                $(k).show("normal"); 
            }else{
                $(k).hide("normal");
            }
        });
    }*/