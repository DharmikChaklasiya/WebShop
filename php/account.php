<?php
/*----------------------------------------------------------------------------------------------
WT2 BIF SS2018 Latosińska - Leithner
    ____             _          ___        _____             __       _  __
   / __ )____ ______(_)___ _   ( o )      / ___/__  ______  / /_____ | |/ /
  / __  / __ `/ ___/ / __ `/  / __ \/|    \__ \/ / / / __ \/ __/ __ `|   / 
 / /_/ / /_/ (__  / / /_/ /  / /_/  <    ___/ / /_/ / / / / /_/ /_/ /   |  
/_____/\__,_/____/_/\__,_/   \____/\/   /____/\__, /_/ /_/\__/\__,_/_/|_|  
                                             /____/                        

date: 08.06.2018

----------------------------------------------------------------------------------------------*/
if ($currentUser != "") 
{
    $username = '';
    $voorname = '';
    $nachname = '';
    $emailadr = '';
    $anrede = '';
    $adresse = '';
    $plz = '';
    $ort = '';
    $zahlung = '';
    if (isset($currentUser))
    {
        $userData = db_connection::getUserData(htmlspecialchars_decode($currentUser));
        if ($userData)
        {
            $anrede = $userData['anrede'];
            $voorname = $userData['vorname'];
            $nachname = $userData['nachname'];
            $adresse = $userData['adresse'];
            $plz = $userData['plz'];
            $ort = $userData['ort'];
            $zahlung = $userData['zahlung'];
            $emailadr = $userData['email'];
        }
    }
    ?>
<div id="userData">
    
	<h3>basic information</h3>
    <form id="updateDataForm" onsubmit="return checkInput()" method="POST" action=<?php echo $_SERVER['PHP_SELF']; ?>>
        <table>
            <tr>
                <td>User name:</td>
                <td><input id="username" class="form-control" name="user" type="text" oninput="strip(this.id);" <?php if ($currentUser != "") echo "readonly value=\"" . $currentUser . "\""; ?>></td>
            </tr>
            <tr>
                <td>Form of address:</td>
                <td><input id="accountAddress" name="anrede" class="form-control accountInput" type="text" <?php echo "value='$anrede'"; ?>></td>
            </tr>
            <tr>
                <td>First name:</td>
                <td><input name="name" class="form-control accountInput" type="text" <?php echo "value='$voorname'"; ?>></td>
            </tr>
            <tr>
                <td>Last name:</td>
                <td><input name="surname" class="form-control accountInput" type="text" <?php echo "value='$nachname'"; ?>></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><input name="adresse" class="form-control accountInput" type="text" <?php echo "value='$adresse'"; ?>></td>
            </tr>
            <tr>
                <td>Postal code:</td>
                <td><input name="plz" class="form-control accountInput" type="text" <?php echo "value='$plz'"; ?>></td>
            </tr>
            <tr>
                <td>Place:</td>
                <td><input name="ort" class="form-control accountInput" type="text" <?php echo "value='$ort'"; ?>></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input name="email" class="form-control accountInput" type="email" <?php echo "value='$emailadr'"; ?>></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input name="password" class="form-control accountInput" type="password"></td>
            </tr>
            <tr>
                <td>Confirm Password:</td>
                <td><input name="passwordConfirmation" class="form-control accountInput" type="password"></td>
            </tr>                   
        </table>  

		<h3>payment information</h3>
        <input name="user_registration" class="form-control" type="hidden">        
        <?php
        }
			$paypal = "./img/paypal.png";
            $visa = "./img/visa.jpg";
            $delivery = "./img/delivery.jpg";
        ?>
        <label class="col-sm-12 col-md-4 col-lg-4">
			<img src="<?php echo $paypal?>" alt="PayPal">
            <input type="radio" name="payment" value="1" <?php if ($zahlung == 1) echo " checked"; ?> /> paypal
        </label>
        <label class="col-sm-12 col-md-4 col-lg-4">
			<img src="<?php echo $visa;?>" alt="Visa">
            <input type="radio" name="payment" value="2" <?php if ($zahlung == 2) echo " checked"; ?> /> visa card
        </label>
        <label class="col-sm-12 col-md-4 col-lg-4">
			<img src="<?php echo $delivery;?>" alt="On delivery">
            <input type="radio" name="payment" value="3" <?php if ($zahlung == 3) echo " checked"; ?> > On delivery
        </label>
        
        <!--<input id="submitPaymentOptions" type="submit" class="btn btn-primary btn-sm" value="Update Payment Options">-->
        <input id="submitUpdateData" type="submit" class="btn btn-primary btn-sm" value="Update User Data" disabled>
    </form>

    <div id="orders">
        <?php include('showOrderDetails.php') ; ?>
    </div>
    
</div>