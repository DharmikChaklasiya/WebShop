<?php
if(isset($_GET['productName']) && !empty($_GET['productName']))
{
    $name = '';
    $price = '';
    $cat = '';
    $rating = '';
    $des = '';
    
    $name = ($_GET['productName']);

    //echo "<script>console.log( 'edit product!: '.$name.' );</script>";

    //Include database
    $config = include("../config.php");
    include("db_connection.php");
   
    $productToEdit = db_connection::getProduct ($name);

	$cat = $productToEdit['category'];
    $price = $productToEdit["price"];
	$rating = $productToEdit['rating'];
	$des = $productToEdit['description'];

    ?>

    <h2>Edit Products</h2>
		<form method="post"> <!-- action=action="index.php?section=Products" enctype="multipart/form-data"-->
			<input name="name" type="text" id="editName" placeholder="Name" value="<?php echo $name; ?>" class="form-control" readonly >
			<select name="category" id="editCategory" class="form-control">      
				<?php
				foreach ($config->categories as $category)
				{
                    if ($category == $cat)
                    {
                        echo '<option selected>'.$category.'</option>'."\n";
                    }
                    else
                    {
                        echo '<option>'.$category.'</option>'."\n";
                    }                        
				}
				?>
			</select>
			<!-- TODO: if in description: available -> green, if not available -> red text-->
			<select name="description" id="editDescription" class="form-control">      
				<?php
				foreach ($config->descriptions as $description)
				{
                    if ($description == $des)
                    {
                        echo '<option selected>'.$description.'</option>'."\n";
                    }
                    else
                    {
                    echo '<option>'.$description.'</option>'."\n";
                    }
				}
				?>
			</select>
			<input name="price" type="text" id="editPrice" placeholder="Price" value="<?php echo $price; ?>" class="form-control">
			<input name="rating" type="text" id="editRating" placeholder="Rating" value="<?php echo $rating; ?>" class="form-control">
			<input type="submit" value="Edit" class="btn btn-primary btn-sm"> 
		</form>	
<?php
}

if (isset($_POST['description'])) // edit Product
{
	$name = $_POST['name'];
	$category = $_POST['category'];
	$price = $_POST['price'];
	$rating = $_POST['rating'];
	$description = $_POST['description'];

	$productData = db_connection::editProduct($category, $price, $description, $rating, $name);		
}
?>
   