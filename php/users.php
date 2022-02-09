<?php
/*----------------------------------------------------------------------------------------------
WT2 BIF SS2018 Latosińska - Leithner
    ____             _          ___        _____             __       _  __
   / __ )____ ______(_)___ _   ( o )      / ___/__  ______  / /_____ | |/ /
  / __  / __ `/ ___/ / __ `/  / __ \/|    \__ \/ / / / __ \/ __/ __ `|   / 
 / /_/ / /_/ (__  / / /_/ /  / /_/  <    ___/ / /_/ / / / / /_/ /_/ /   |  
/_____/\__,_/____/_/\__,_/   \____/\/   /____/\__, /_/ /_/\__/\__,_/_/|_|  
                                             /____/                        

date: 09.06.2018

----------------------------------------------------------------------------------------------*/
?>
<div id="user">	
	<table class="col-sm-12 col-md-6 col-lg-6">
		<tr>
			<th>Inactive</th>
			<th>Username</th>
			<!--<th>Anrede</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Address</th>
			<th>Post Code</th>
			<th>Place</th>
			<th>Email</th>-->
			<th>Payment method</th>
			<th>Orders</th>
		</tr>
		<?php
		$checked = '';
		$userResult = db_connection::getAllUser();			
		if ($userResult)
		{
			while($row = $userResult->fetch_assoc())
			{
				$isActive = $row['is_active'];
				if ($isActive == 0)
				{
					$checked = 'checked';
				}
				else 
				{
					$checked = '';
				}

				echo '<tr>';
					// TODO: call db_connection::setUserActive($row['username'], );
					echo "<td><input type='checkbox' name='inactive' value=".$row['username']." class='inactiveChecked' ".$checked." ></td>";
					echo "<td class='inactiveUser'>".$row['username']." </td>";
					/*echo '<td>'.$row['anrede'].'</td>';
					echo '<td>'.$row['vorname'].'</td>';
					echo '<td>'.$row['nachname'].'</td>';
					echo '<td>'.$row['adresse'].'</td>';
					echo '<td>'.$row['plz'].'</td>';
					echo '<td>'.$row['ort'].'</td>';
					echo '<td>'.$row['email'].'</td>';*/
					
					$imgSource = "./img/delivery.jpg";
					if ($row['zahlung'] == 1)
					{
						$imgSource = "./img/visa.jpg";
					}
					else
					{
						$imgSource = "./img/paypal.png";
					}
					
					//echo '<td>'.$row['zahlung'].'</td>';
					echo "<td><img src='$imgSource' class='paymentImg' alt='paymentInfo'></td>";
					//<input type="submit" name="add_to_cart" class="btn btn-primary btn-sm col-lg-2 col-md-2 col-sm-3 col-xs-6" value="Buy" />
					echo "<td><input type='submit' value='Details' name=".$row['username']." class='showDetails btn btn-primary btn-sm'/></td>";?>
				</tr>

			<?php }
		}?>
	</table>

	

	<div class="col-sm-12 col-md-6 col-lg-6">
		<h2><?php if ($admin == 1) echo "All orders"; else echo "My orders"; ?></h2>
			<table>
				<tr>
					<th>Order ID</th>
					<th>Order date</th>
					<th>Username</th>
				</tr>
			
		<?php
			//$userOrder = 
			$productResult = db_connection::getAllOrdersForUser(($admin == 1) ? "" : $currentUser);
			if ($productResult)
			{
				while($row = $productResult->fetch_assoc())
				{
					echo '<tr>';
						echo '<td>'.$row['order_id'].'</td>';
						echo '<td>'.$row['date'].'</td>';
						echo '<td>'.$row['user'].'</td>';
					echo '</tr>';
				}
			}?>
			</table>
	</div>
	<div id="detResult">
		
	</div>
</div>