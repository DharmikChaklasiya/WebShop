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
//var_dump($_POST);
if (isset($_POST['clear_cart']))
{
	//session_unset('cart');
	unset($_SESSION['cart']);
	//header("Refresh:0"); // reloads the current page
	
	echo "Cart cleared";
}
else if (isset($_POST['make_order']))
{
	$voucher = null;
	if (isset($_POST['voucher']) && $_POST['voucher'] != '')
	{
		$voucher = $_POST['voucher'];
	}
	
	if (db_connection::placeOrder($voucher))
	{
		echo "order successfull";
		unset($_SESSION['cart']);
	}
}
else if(isset($_POST['increase']))
{
	foreach($_SESSION['cart'] as $key => $product)
	{
		if ($product['name'] == $_POST['product'])
		{			
			$_SESSION['cart'][$key]['quantity'] += 1; //increase the quantity of the product with the right id
		}
	}
}
else if(isset($_POST['decrease']))
{
	foreach($_SESSION['cart'] as $key => $product)
	{
		if ($product['name'] == $_POST['product'])
		{
			$_SESSION['cart'][$key]['quantity'] -= 1;
			if ($_SESSION['cart'][$key]['quantity'] < 1) //if quantity is 0 unset the session array on position $key
			{
				unset($_SESSION['cart'][$key]);
			}
		}
	}
}
else if(isset($_POST['action']) && $_POST['action'] == "redeemVoucher")
{
	//$value = db_connection::getValuefromVouchers($_POST['code']);
	//echo $value;
}
?>
<h2>Cart</h2>

<?php
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0)
{
	$sum = 0;
	$column = 1;
	if (count($_SESSION['cart']) > 0): ?>
	
		<div id="inCart"> 
			<table>
				<thead>
					<tr>
						<!-- <th><?php /*echo implode('</th><th>', array_keys(current($_SESSION['cart'])));*/ ?></th> -->
						<th>Name</th>
						<th>Quantity</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($_SESSION['cart'] as $key => $product)
				{?>
					<tr>
					
					<td><?php echo pathinfo($product['name'], PATHINFO_FILENAME) ;?></td>
					<td><?php echo $product['quantity'] ;?></td>
					<td><?php echo $product['price']." €" ;?></td>
					<td><form method="post" action="?section=<?php echo $_GET["section"]; ?>">
						<input type="hidden" name="product" value="<?php echo $product['name']; ?>" />
						<button type="submit" name="increase" class="btn-success btn-xs glyphicon-plus"></button>
						<button type="submit" name="decrease" class="btn-danger btn-xs glyphicon-minus"></button>
					</form></td>

					<?php $sum += $product['quantity'] * $product['price'] ?>

					</tr>

				<?php } ?>
				<tr>
					<td><b><?php echo "Sum: "?></b></td>
					<td></td>
					<td><b><?php echo $sum." €" ?></b></td>
				</tr>
				</tbody>
			</table>

	<?php endif; ?>

			<!--TODO: clear also number in nav -->
			<form method="post" action=<?php echo $_SERVER['PHP_SELF']; ?>>
				<input type="submit" name="clear_cart" class="btn btn-primary btn-sm" value="clear"/>
			</form>

				
			<?php
			if (isset($currentUser))
			{
			?>
			<form method="post" action=<?php echo $_SERVER['PHP_SELF']; ?>>
				<input id="divVoucherValue" readonly /> %<br/>
				<label>voucher:&nbsp;<input id="inputVoucherCode" value="<?php (isset($_POST['action']) && isset($_POST['code'])) ? $_POST['code'] : "" ?>" name="voucher" type="text" placeholder="redeem code"/></label><br/><br/>
				<h3>payment option</h3>
				<input name="user_registration" class="form-control" type="hidden">        
				<?php
					$paypal = "./img/paypal.png";
					$visa = "./img/visa.jpg";
					$delivery = "./img/delivery.jpg";
				?>
				<label class="col-sm-12 col-md-12 col-lg-12">
					<img src="<?php echo $paypal?>" alt="PayPal" class='paymentImg' alt='paymentInfoPP'>
					<input type="radio" class="cartPaymentOption" name="payment" value="1" <?php /*if ($zahlung == 1) echo " checked";*/ ?> /> paypal
				</label>
				<label class="col-sm-12 col-md-12 col-lg-12">
					<img src="<?php echo $visa;?>" alt="Visa" class='paymentImg' alt='paymentInfoVisa'>
					<input type="radio" class="cartPaymentOption" name="payment" value="2" <?php /*if ($zahlung == 2) echo " checked";*/ ?> /> visa card
				</label>
				<label class="col-sm-12 col-md-12 col-lg-12">
					<img src="<?php echo $delivery;?>" alt="On delivery" class='paymentImg' alt='paymentInfoDelivery'>
					<input type="radio" class="cartPaymentOption" name="payment" value="3" <?php /*if ($zahlung == 3) echo " checked";*/ ?> > On delivery
				</label>
				<br/>
				<input id="btnMakeOrder" type="submit" name="make_order" class="btn btn-primary btn-sm" value="place order" disabled/><br/>
			</form>	
			<?php
			}
			else
			{
				echo "<p><br/>Please login to order</p>";
			}
}
else
{
	echo "<br/>no products added yet";
}
?>
</div>