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
class voucher
{
	$code;
	$status;
	$value;
	$date;
	
	function __construct ()
	{
		//print "empty voucher ctor...\n";
		$code = '';
		$status = '';
		$value = '';
		$date = '';
    }
	
	function __construct ($i_code, $i_status, $i_value, $i_date)
	{
		//print "param voucher ctor...\n";
		$code = $i_code;
		$status = $i_status;
		$value = $i_value;
		$date = $i_date;
    }
	
	function __destruct ()
	{
		//print "voucher dtor...\n";
	}
}
?>