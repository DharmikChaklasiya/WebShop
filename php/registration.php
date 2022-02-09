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
if ($currentUser == "") 
{
    $username = '';
    $voorname = '';
    $nachname = '';
    $emailadr = '';
    $anrede = '';
    $adresse = '';
    $plz = '';
    $ort = '';
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
            $emailadr = $userData['email'];
        }
    }
    ?>
    <form id="registrationForm" onsubmit="return checkInput()" method="POST" action=<?php echo $_SERVER['PHP_SELF']; ?>>
    <table>
        <tr>
            <td>User name:</td>
            <td><input id="username" name="user" type="text" class="registrationInput" <?php if ($currentUser != "") echo "readonly value=\"" . $currentUser . "\""; ?>></td> <!--oninput="strip(this.id);"-->
        </tr>
        <tr>
            <td>Form of address:</td>
            <td><input name="anrede" type="text" class="registrationInput" <?php echo "value='$anrede'"; ?>></td>
        </tr>
        <tr>
            <td>First name:</td>
            <td><input name="name" type="text" class="registrationInput" <?php echo "value='$voorname'"; ?>></td>
        </tr>
        <tr>
            <td>Last name:</td>
            <td><input name="surname" type="text" class="registrationInput" <?php echo "value='$nachname'"; ?>></td>
        </tr>
        <tr>
            <td>Address:</td>
            <td><input name="adresse" type="text" class="registrationInput" <?php echo "value='$adresse'"; ?>></td>
        </tr>
        <tr>
            <td>Postal code:</td>
            <td><input name="plz" type="text" class="registrationInput" <?php echo "value='$plz'"; ?>></td>
        </tr>
        <tr>
            <td>Place:</td>
            <td><input name="ort" type="text" class="registrationInput" <?php echo "value='$ort'"; ?>></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input name="email" type="email" class="registrationInput" <?php echo "value='$emailadr'"; ?>></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input name="password" type="password" class="registrationInput" ></td>
        </tr>
        <tr>
            <td>Confirm Password:</td>
            <td><input name="passwordConfirmation" class="registrationInput" type="password"></td>
        </tr>
        <tr>
            <td><input name="user_registration" type="hidden"></td>
        </tr>
    </table>
    <input id="btnCreateAccount" class="btn btn-primary btn-sm" type="submit" value="Create Account" disabled>
    </form>
<?php
}
?>

<!--<script src="../js/form_check.js" type="text/javascript"></script>-->