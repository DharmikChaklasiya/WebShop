<?php
$user = '';

if (isset($_GET['showDet']) && !empty($_GET['showDet']))
{
    $user = ($_GET['showDet']);
    
    $config = include("../config.php"); //Include database
    include("db_connection.php");
	
	echo "<h2>orders for user '".$user."'</h2>";
}
else if (isset($_POST['print_order']) && !empty($_POST['print_order']))
{
	$config = include("../config.php");
    include("db_connection.php");
	
	echo "<h2>print order</h2>";
}
else if (isset($currentUser))
{
    $user = $currentUser;
	
	echo "<h3>my orders</h3>";
}  

    $orders = '';
    $details = '';
    $idx = 0;
	$lastOrderId = 0;

    $orders = db_connection::getAllOrdersForUser($user);
    if ($orders->num_rows > 0)
    {
		$vouchers = db_connection::getVouchers();
		//echo var_dump($vouchers);
		$arrVouchers = array();
		while ($row = $vouchers->fetch_assoc())
		{
			$arrVouchers[$row['code']] = $row;
		}		
		//echo var_dump($arrVouchers);
		
		$products = db_connection::getAllProducts();
		//echo var_dump($products);
		$arrProducts = array();
		while ($row = $products->fetch_assoc())
		{
			$arrProducts[$row['name']] = $row;
		}		
		//echo var_dump($arrProducts);
		
        echo "<table>";
            echo "<tr>";
				echo "<th>Order ID</th>";
				echo "<th>Order date</th>";
				//echo "<th>Username</th>";
				echo "<th>Product</th>";
				echo "<th>Quantity</th>";
				echo "<th>Price</th>";
            echo "</tr>";

        while ($row = $orders->fetch_assoc())
		{
			// not show other orders than selected in print view
			if (isset($_POST['print_order']) && !empty($_POST['print_order']))
			{
				if (isset($_POST['order_id']) && !empty($_POST['order_id']))
				{
					if ($_POST['order_id'] != $row['order_id'])
					{
						continue;
					}
				}
			}
					
            $details = db_connection::getAllDetailsForId($row['order_id']);
			if ($details->num_rows <= 0)
			{
				continue;
			}
			
            if ($details)
            {
				$sum = 0;
				while ($det = $details->fetch_assoc())
                {
					$idx += 1;
                    echo '<tr>';
						if ($lastOrderId != $row['order_id'])
						{
							$lastOrderId = $row['order_id'];
							echo "<td>".$row['order_id']."</td>";
							echo "<td>".$row['date']."</td>";
						}
						else
						{
							echo "<td></td>";
							echo "<td></td>";
						}
						//echo "<td>".$row['user']."</td>";
                        echo "<td>".pathinfo($det['fk_product'], PATHINFO_FILENAME)."</td>";
                        echo "<td>".$det['count']."</td>";
						$price = $arrProducts[$det['fk_product']]['price'];
						echo "<td>".$price." €</td>";
						if (!isset($currentUser) && !isset($_POST['print_order'])) // allow delete for admin
						{
							echo '<td>';
								//echo '<form method="post" action='.$_SERVER['PHP_SELF'].'>';
									//echo '<button type="submit" name='.$det['fk_product'].' class="btnDeleteOrderItem btn-danger btn-xs glyphicon-minus"></button>';
									echo '<button type="submit" class="btnDeleteOrderItem btn-danger btn-xs glyphicon-minus" onclick="javascript:delete_orderItem(\''.$det['fk_product'].'\',\''.$det['id'].'\')"></button>';
								//echo '</form>';
							echo '</td>';
						}
                    echo '</tr>';
					$sum += $det['count']*$price;
                }

				if ($row['fk_voucher'] != NULL)
				{
					echo '<tr>';
						echo '<td><b>Sum:</b></td>';
						echo '<td></td>';
						echo '<td></td>';
						echo '<td></td>';
						echo '<td><b>'.$sum.' €</b></td>';
					echo '</tr>';
					
					$percent = $arrVouchers[$row['fk_voucher']]['value'];
					echo '<tr>';
						echo '<td><b>Code:</b></td>';
						echo '<td></td>';
						echo '<td></td>';
						echo '<td>'.$row['fk_voucher'].'</td>';
						echo '<td><b>-'.$percent.' %</b></td>';
					echo '</tr>';
					$sum *= (100 - $percent)/100;
				}
				
				echo '<tr>';
					echo '<td><b>Total sum:</b></td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td><b>'.$sum.' €</b></td>';
					if (isset($currentUser))
					{
						echo '<td>';
							echo '<form method="post" target="_blank" action="./php/showOrderDetails.php">';
								echo '<input type="hidden" name="order_id" value="'.$lastOrderId.'"/>';
								echo '<input type="submit" name="print_order" class="btn btn-primary btn-sm" value="print"/>';
							echo '</form>';
						echo '</td>';
					}
				echo '</tr>';
				echo '<tr>';
					echo '<td><br/></td>';
				echo '</tr>';
            }
        }
        echo "</table>";
    }
    else
    {      
        echo "No user with orders!";
    }
?>