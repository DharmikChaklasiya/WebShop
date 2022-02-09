<?php
/*----------------------------------------------------------------------------------------------
WT2 BIF SS2018 Latosińska - Leithner
    ____             _          ___        _____             __       _  __
   / __ )____ ______(_)___ _   ( o )      / ___/__  ______  / /_____ | |/ /
  / __  / __ `/ ___/ / __ `/  / __ \/|    \__ \/ / / / __ \/ __/ __ `|   / 
 / /_/ / /_/ (__  / / /_/ /  / /_/  <    ___/ / /_/ / / / / /_/ /_/ /   |  
/_____/\__,_/____/_/\__,_/   \____/\/   /____/\__, /_/ /_/\__/\__,_/_/|_|  
                                             /____/                        

date: 07.06.2018

----------------------------------------------------------------------------------------------*/
function make_thumb ($src, $dest, $desired_width)
{
	/* read the source image */
	$source_image = @imagecreatefromjpeg($src);
	if(!$source_image) // if not jpeg: try png:
    {
		$source_image = @imagecreatefrompng($src);
		if(!$source_image) // if not png: try gif:
		{
			$source_image = imagecreatefromgif($src);
		}
	}

	$width = imagesx($source_image);
	$height = imagesy($source_image);
	
	/* find the "desired height" of this thumbnail, relative to the desired width  */
	$desired_height = floor($height * ($desired_width / $width));
	
	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
	
	/* copy source image at a resized size */
	imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
	
	/* create the physical thumbnail image to its destination */
	imagejpeg($virtual_image, $dest);
}
?>

<link rel="stylesheet" type="text/css" href="css/dropzone.css"/>

<?php
/*$config = include("config.php");
$admin = 0;
if (isset($currentUser))
{
	$userData = db_connection::getUserData(htmlspecialchars_decode($currentUser));
	if ($userData)
	{
		$admin = $userData['is_admin'];
	}
}*/

/*
if (isset($_GET['delete']) && $_GET['delete'])
{
	header('Location: '.strtok($_SERVER["REQUEST_URI"], '?'));

	unlink("./img/thumbnail/".pathinfo($_GET['delete'], PATHINFO_FILENAME)."_thumbnail.jpg");
	unlink($_GET['delete']); 	// bool unlink ( string $filename [, resource $context ] ) - deletes a file
}*/

// remove from DB
if (isset($_POST['delete']))
{	
	$name = $_POST['delete'];
	//$rawname = pathinfo($name, PATHINFO_BASENAME);

	$removeProduct = db_connection::getProduct(htmlspecialchars_decode($name));
	if ($removeProduct)
	{
		if ($debugMode)
		{
			echo $name." should be deleted";
		}
		
		//$name = $_POST['delete'];
		db_connection::deleteProduct($name);

		unlink("./img/thumbnail/".pathinfo($name, PATHINFO_FILENAME)."_thumbnail.jpg");
		//TODO: $name inclusive .jpg was not accepted - permision denied
		unlink("./img/products/".pathinfo($name, PATHINFO_FILENAME).".jpg"); // bool unlink ( string $filename [, resource $context ] ) - deletes a file
		//unlink($image);
	}
}

$subdir = $config->products_dir;
if (isset($_FILES['userfile'])) // wurde Datei per POST-Methode upgeloaded
{
	$fileupload = $_FILES['userfile'];
	if ($debugMode)
	{
		//var_dump($fileupload);	// diverse Statusmeldungen ausschreiben
		echo "name: ".$fileupload['name']." <br>";				// Originalname der hochgeladenen Datei
		echo "type: ".$fileupload['type']." <br>";				// Mimetype der hochgeladenen Datei
		echo "tmp_name: ".$fileupload['tmp_name']." <br>";		// Name, wie die hochgeladene Datei im temporären Verzeichnis heißt
		echo "error: ".$fileupload['error']." <br>";			// eventuelle Fehlermeldung
		echo "size: ".$fileupload['size']." <br>";				// Größe der hochgeladenen Datei		
		echo "ziel: ".$subdir.$fileupload['name']." <br>";		// Pfad und Dateiname, wo die hochgeladene Datei hinkopiert werden soll
		echo "<br>";
	}

	// Prüfungen, ob Dateiupload funktioniert hat
	if ($fileupload['size'] <= 0) 			// Größe > 0
	{
		//echo '<script type="text/javascript">alert("Nothing to upload!");</script>';
	}
	else if ($fileupload['error'] !== 0) 	// kein Fehler passiert
	{
		if ($fileupload['error'] !== 4) 	// Fehler 4 --> leeres file
		{
			echo '<script type="text/javascript">alert("Upload failed with error code: ' . $fileupload['error'] . '");</script>';
		}
	}
	else if ($fileupload['size'] > $config->max_file_size)	// Dateigröße in Ordnung
	{
		echo '<script type="text/javascript">alert("Upload failed: file exeeds maximum size of 512000 Bytes");</script>';
	}
	//else if (($fileupload['type'] !== 'image/png') && ($fileupload['type'] !== 'image/jpeg') && ($fileupload['type'] !== 'image/gif'))
	else if (in_array($fileupload['type'], $config->img_types) == false)
	{
		echo '<script type="text/javascript">alert("Upload failed: Not a valid file type: ' . $fileupload['type'] . '. Only gif/jpeg/png allowed.");</script>';
	}
	// hochgeladene Datei hat einen temporären Namen -> nur dann true, wenn Datei gerade erst hochgeladen wurde
	else if ($fileupload['tmp_name'] && is_uploaded_file($fileupload['tmp_name']))
	{
		//echo '<script type="text/javascript">alert("Upload successfull for: '.$fileupload['name'].'!");</script>';
		move_uploaded_file($fileupload['tmp_name'], $subdir.$fileupload['name']);  // erst dann ins neue Verzeichnis verschieben

		// create thumbnail
		$src = $subdir.$fileupload['name'];
		$dest = "./img/thumbnail/".pathinfo($src, PATHINFO_FILENAME)."_thumbnail.jpg";
		/*echo "<script>console.log( 'pathinfo($src): " . pathinfo($src) . "' );</script>";
		echo "<script>console.log( 'pathinfo($src, PATHINFO_DIRNAME ): " . pathinfo($src, PATHINFO_DIRNAME ) . "' );</script>";
		echo "<script>console.log( 'pathinfo($src, PATHINFO_BASENAME  ): " . pathinfo($src, PATHINFO_BASENAME  ) . "' );</script>";
		echo "<script>console.log( 'pathinfo($src, PATHINFO_EXTENSION  ): " . pathinfo($src, PATHINFO_EXTENSION ) . "' );</script>";
		echo "<script>console.log( 'pathinfo($src, PATHINFO_FILENAME   ): " . pathinfo($src, PATHINFO_FILENAME) . "' );</script>";*/
		//echo "<script>console.log( 'src: " . $src . "' );</script>";
		//echo "<script>console.log( 'dest: " . $dest . "' );</script>";
		make_thumb($src, $dest, 200);
	}
}

$selectedCat = $config->categories[0];
if ($admin == 0)
{
	if (isset($_GET['category']) && $_GET['category'])
	{
		$selectedCat = $_GET['category'];
	}
?>
	<!-- TODO: set an action-->
	<form id="updateCategory" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div class="col-sm-12 col-md-2 col-lg-2">
			<select name="category" class="form-control form-control-sm" onchange="this.form.submit();">      
				<?php
				foreach ($config->categories as $category)
				{
					echo '<option value="'.$category.'"';
					if ($category == $selectedCat)
					{
						echo ' selected';
					}
					echo '>'.$category.'</option>';
				}?>
			</select>
		</div>
		<!-- not needed anymore: is handled in select: onchange
		<div class="col-sm-12 col-md-2 col-lg-2">
			<input type="submit" name="update" value="update" class="form-control form-control-sm">
		</div>-->
	</form>

	<div class="input-group col-sm-12 col-md-4 col-lg-4">
		<span class="input-group-addon">Search</span>
		<input type="search" name="keyword" id="searchInput" placeholder="search for products" class="form-control form-control-sm" />
    </div>
<?php
}
if ($admin == 1) // Display products-upload area
{
?>
<div>
	<div class="col-sm-12 col-md-4 col-lg-4">
		<h2>Upload Products</h2>	
		<form id="upload" method="post" action=<?php echo $_SERVER['PHP_SELF']; ?> enctype="multipart/form-data">	
			<select name="category" id="category" class="form-control">      
				<?php
				foreach ($config->categories as $category)
				{
					echo '<option>'.$category.'</option>'."\n";
				}
				?>
			</select>
			<!-- TODO: if in description: available -> green, if not available -> red text-->
			<select name="description" id="description" class="form-control">      
				<?php
				foreach ($config->descriptions as $description)
				{
					echo '<option>'.$description.'</option>'."\n";
				}
				?>
			</select>
			<input name="price" type="text" id="price" placeholder="Price" class="form-control">
			<input name="rating" type="text" id="rating" placeholder="Rating" class="form-control">
			<input type="hidden" name="MAX_FILE_SIZE" value="1024000">
			Filename: <input name="userfile" type="file" accept="image/jpeg,image/gif,image/png">
			<input class="upload" type="submit" value="Upload"> 
			<!-- id="uploadBut" onclick="uploadFromDropZone()"-->
		</form>	

		<!--<div id="dropbox">Drop files here to upload...</div> doesn't work with product information, use for cart! -->
		<!--<form method="post" id="dropzone" class="dropzone" action="index.php?section=Products" enctype="multipart/form-data"></form>-->

		<div id="resultsEditProduct"></div>

	</div>
	<?php
	echo "<div id='result' class='col-sm-12 col-md-8 col-lg-8'>";
}
else
{
	echo "<div id='result' class='col-sm-12 col-md-12 col-lg-12'>";
}

if (isset($_POST['MAX_FILE_SIZE']) && isset($_POST['description'])) // save product in database
{
	$current_product = $fileupload['name'];
	$category = $_POST['category'];
	$price = $_POST['price'];
	$description = $_POST['description'];
	$rating = $_POST['rating'];
	if ($config->debug)
	{
		echo "product in Post was set: ".$current_product.", category: ".$category.", price: ".$price.", description: ".$description.", rating: ".$rating;
	}
	/* TODO: product_name must be unique or id*/
	$productData = db_connection::addProduct ($current_product, $category, $price, $description, $rating);
	if ($productData)
	{
		echo '<div class="alert alert-success">added product!</div>';
	}
}
else if (isset($_POST['description'])) // edit Product, buy
{
	$name = $_POST['name'];
	$category = $_POST['category'];
	$price = $_POST['price'];
	$rating = $_POST['rating'];
	$description = $_POST['description'];
	if ($config->debug)
	{
		echo "product in Post was set ".$name.", category: ".$category.", price: ".$price.", description: ".$description.", rating: ".$rating;
	}

	$productData = db_connection::editProduct($category, $price, $description, $rating, $name);		
}
	
	// The glob() function searches for all the pathnames matching pattern according to the rules used 
	// by the libc glob() function, which is similar to the rules used by common shells. 
	// GLOB_BRACE - Expands {a,b,c} to match 'a', 'b', or 'c'

	//$images = glob($subdir. "*.{jpg,gif,png}", GLOB_BRACE); 

	$productData = db_connection::getAllProducts();

    if($productData && $productData != '')
    {
		//foreach ($images as $image)
		while ($product = $productData->fetch_assoc())
		{
			$filename = $product['name'];
			$name = pathinfo($filename, PATHINFO_FILENAME);
			$imgThumb = "./img/thumbnail/".$name."_thumbnail.jpg";
			//Just show up the selected category
			if ($selectedCat == $product['category'] || $admin == 1)
			{
			?>
				<!-- Make a div for the products to order -->
				<div class="class='col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group hide_prods">
					<!--<form method="post" action=<?php /*echo $_SERVER['PHP_SELF'];*/ ?>> -->
					<form method="post" action=<?php echo "javascript:add_product('$name',".$product['price'].")"; ?>>
						<div class="products">
							<img src="<?php echo "$imgThumb"; ?>" class="img-responsive" title=<?php echo "'$filename'"?> alt=<?php echo "'$name'";?> draggable="true" ondragstart="drag(event)"/>

							<div class="product-info">
								<p class="text-info"><?php echo $name; ?></p>
								<p><?php echo $product['category']; ?></p>
								<p>Rating: <?php echo $product['rating']; ?></p>
								<p>Price: <?php echo $product['price']; ?> €</p>
								<p><?php echo $product['description']; ?></p>
								<input type="hidden" name="name" value="<?php echo $filename; ?>" />
								<input type="hidden" name="category" value="<?php echo $product['category']; ?>" />
								<input type="hidden" name="rating" value="<?php echo $product['rating']; ?>" />
								<input type="hidden" name="price" value="<?php echo $product['price']; ?>" />
								<input type="hidden" name="description" value="<?php echo $product['description']; ?>" />
								<?php if ($admin == 0)
								{
								?>
									<!--<input type="text" name="quantity" class="quantity col-lg-2 col-md-2 col-sm-3 col-xs-6" value="1" />-->
									<input type="submit" name="add_to_cart" class="btn btn-primary btn-sm col-lg-2 col-md-2 col-sm-3 col-xs-6" value="Buy" />
								<?php
								}
								?>
							</div>
						</div>
					</form>
					<?php if ($admin == 1) {?>											
						<form method='post'>
							<input type='hidden' name='delete' value="<?php echo $filename; ?> ">
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
	
</div>

<script src="js/dropzone.js"></script>