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

<div id="voucher">
	<form id="createVoucher" method="POST" action="javascript:generateVoucher()" class="col-sm-12 col-md-2 col-lg-2">
		<div>
			<label>Value [%]: <input id="value" name="value" class="form-control" type="number"></label>
			<label>Valid till date: <input id="date" name="date" class="form-control" type="date" required value=<?php echo date('Y-m-d'); ?>></label>
			<label>Code: <input id="code" name="code" class="form-control" type="text" readonly></label>
			<input id="btnCreateVoucher" type="submit" name="create" value="create" disabled class="btn btn-primary btn-sm form-control form-control-sm">
		</div>
	</form>
	
	<table>
		<tr>
			<th>Status</th>
			<th>Code</th>
			<th>Value</th>
			<th>Date</th>
		</tr>
		<?php
		$productResult = db_connection::getVouchers();			
		if ($productResult)
		{
			while($row = $productResult->fetch_assoc())
			{
				echo '<tr>';
					if ($row['date'] < date("Y-m-d"))
					{
						echo '<td>ABGELAUFEN</td>';
					}
					else if ($row['status'] == 0)
					{
						echo '<td>AKTIV</td>';
					}
					else
					{
						echo '<td>EINGELÖST</td>';
					}
					echo '<td>'.$row['code'].'</td>';
					echo '<td>'.$row['value'].'</td>';
					echo '<td>'.$row['date'].'</td>';
				echo '</tr>';
			}
		}?>
	</table>
</div>