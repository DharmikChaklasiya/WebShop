<?php
/*----------------------------------------------------------------------------------------------
WT2 BIF SS2018 Latosińska - Leithner
    ____             _          ___        _____             __       _  __
   / __ )____ ______(_)___ _   ( o )      / ___/__  ______  / /_____ | |/ /
  / __  / __ `/ ___/ / __ `/  / __ \/|    \__ \/ / / / __ \/ __/ __ `|   / 
 / /_/ / /_/ (__  / / /_/ /  / /_/  <    ___/ / /_/ / / / / /_/ /_/ /   |  
/_____/\__,_/____/_/\__,_/   \____/\/   /____/\__, /_/ /_/\__/\__,_/_/|_|  
                                             /____/                        

date: 10.06.2018

----------------------------------------------------------------------------------------------*/
// save product in SESSION
if (isset($_POST) && isset($_POST['add_to_cart'])) // save product in SESSION
{
	//echo "<br/>POST:<br/>";
	//echo var_dump($_POST);

	//check if session array has been set
	if (isset($_SESSION['cart']))
	{
		$product_ids = array(); //array for the product ids the be loaded
		
		//keep track of how mnay products are in the shopping cart
		$count = count($_SESSION['cart']);
		//echo "Cart count: ".$count."<br/><br/>";
		
		//create array for matching array keys to products id's
		$product_ids = array_column($_SESSION['cart'], 'name');

		//If product do not exist in array
		if (!in_array(filter_input(INPUT_POST, 'name'), $product_ids))
		{
			$_SESSION['cart'][$count] = array
			(
				'name' => $_POST['name'],
				'price' => $_POST['price'],
				'quantity' => 1
			);
		}
		else 
		{   //product already exists, increase quantity
			//match array key to id of the product being added to the cart
			for ($idx = 0; $idx < count($product_ids); $idx++)
			{
				if ($product_ids[$idx] == filter_input(INPUT_POST, 'name'))
				{
					//add item quantity to the existing product in the array
					$_SESSION['cart'][$idx]['quantity'] += 1;
				}
			}
		}

	}
	else
	{   //if shopping cart doesn't exist, create first product with array key 0
		//create array using submitted form data, start from key 0 and fill it with values
		$_SESSION['cart'][0] = array
		(
			'name' => $_POST['name'],
			'price' => $_POST['price'],
			'quantity' => 1
		);
	}
}
?>