<?php
/*----------------------------------------------------------------------------------------------
WT2 BIF SS2018 Latosińska - Leithner
    ____             _          ___        _____             __       _  __
   / __ )____ ______(_)___ _   ( o )      / ___/__  ______  / /_____ | |/ /
  / __  / __ `/ ___/ / __ `/  / __ \/|    \__ \/ / / / __ \/ __/ __ `|   / 
 / /_/ / /_/ (__  / / /_/ /  / /_/  <    ___/ / /_/ / / / / /_/ /_/ /   |  
/_____/\__,_/____/_/\__,_/   \____/\/   /____/\__, /_/ /_/\__/\__,_/_/|_|  
                                             /____/                        

date: 10.03.2018

----------------------------------------------------------------------------------------------*/
?>

<?php
return (object) array
(
    'host'          => 'localhost',
	'port'          => 80,
	'user'			=> 'Michi',
	'password'		=> 'liebtBasia',
	
	// LDAP Informationen:
	'ldap_path'		=> 'ldap.technikum-wien.at',
	'ldap_base'		=> 'dc=technikum-wien,dc=at',
	
	// Datenbankinformationen:
	'db_name' 		=> 'ss2018_wt',	// Name der Datenbank
    'db_host'       => 'localhost', 	// Name, Adresse oder IP des MySQL Servers. Standardmäßig: localhost
	'db_user'       => 'root', 			// Username zum einloggen am MySQL Server
    'db_pass'       => 'liebtBasia', 	// Passwort zum einloggen am MySQL Server
	
	// RSS feed
	'feed_address'	=> 'http://www.blumen-abc.net/rss2.php',
	
	'loginMode'		=> 'database', 			//'ldap', //'hardcoded'
	'debug'			=> false, //true,
    //'sections' 		=> array('Home', 'Products', 'Account', 'Cart', 'Users', 'Vouchers'),
	'sections' 		=> array(),
    'products_dir'   => './img/products/',
	'max_file_size'	=> 512000,
	'img_types'   	=> array('image/png', 'image/jpeg', 'image/gif'),
	'categories'	=> array('white', 'red', 'orange', 'pink', 'purple', 'colour-mix'),
	'descriptions'	=> array('Available', 'Not available')
);
?>