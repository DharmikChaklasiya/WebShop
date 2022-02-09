<?php

    if($_GET['keyword'] && !empty($_GET['keyword']))
    {      
        $config = include("../config.php");
        include("db_connection.php");

        $selectedCat = $config->categories[0];
        
        $admin = 0;
        if (isset($currentUser))
        {
            $userData = db_connection::getUserData(htmlspecialchars_decode($currentUser));
            if ($userData)
            {
                $admin = $userData['is_admin'];
            }
        }
		
        //Include database
        $productData = db_connection::searchProduct(htmlspecialchars_decode($_GET['keyword']));
        if($productData && $productData != '')
        {
            //foreach ($images as $image)
            while ($product = $productData->fetch_assoc())
            {
                $name = pathinfo($product['name'], PATHINFO_FILENAME);
                $imgThumb = "./img/thumbnail/".$name."_thumbnail.jpg";
                //Just show up the selected category
                if ($selectedCat == $product['category'] || $admin == 1)
                ?>
                
                <!-- Make a div for the products to order -->
                <div class="class='col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group hide_prods">
                    <form method="post" action="?section=<?php echo $_GET["section"]; ?>">
                        <div class="products">
                            <img src="<?php echo "$imgThumb"; ?>" class="img-responsive" />
                            <div class="product-info">
                                <p class="text-info"><?php echo $name; ?></p>
                                <p><?php echo $product['category']; ?></p>
                                <p>Rating: <?php echo $product['rating']; ?></p>
                                <p>Price: <?php echo $product['price']; ?> €</p>
                                <p><?php echo $product['description']; ?></p>
                                <input type="hidden" name="name" value="<?php echo $product['name']; ?>" />
                                <input type="hidden" name="category" value="<?php echo $product['category']; ?>" />
                                <input type="hidden" name="rating" value="<?php echo $product['rating']; ?>" />
                                <input type="hidden" name="price" value="<?php echo $product['price']; ?>" />
                                <input type="hidden" name="description" value="<?php echo $product['description']; ?>" />
                                <?php if ($admin == 0) 
								{?>
								<!--<input type="text" name="quantity" class="quantity col-lg-2 col-md-2 col-sm-3 col-xs-6" value="1" />-->
								<input type="submit" name="add_to_cart" class="btn btn-primary btn-sm col-lg-2 col-md-2 col-sm-3 col-xs-6" value="Buy" />
								<?php } ?>
							</div>
						</div>
					</form>
					<?php if ($admin == 1)
					{?>											
						<form method='post'>
							<input type='hidden' name='delete' value='".$name."'>
							<input value='Delete' type='submit' class='btn btn-primary btn-sm'>					
						</form>						
					<?php } ?>
				</div>
			<?php  
			}
        }?>

            <!-- Get the results from our search -->
            <div id="results"></div>
        <?php

        
    }
?>
   