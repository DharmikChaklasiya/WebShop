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
class product
{
	$name;
	$category;
	$price;
	$description;
	$rating;
	
	function __construct ()
	{
		//print "empty product ctor...\n";
		$name = '';
		$category = '';
		$price = '';
		$description = '';
		$rating = '';
    }
	
	function __construct ($i_name, $i_category, $i_price, $i_description, $i_rating)
	{
		//print "param product ctor...\n";
		$name = $i_name;
		$category = $i_category;
		$price = $i_price;
		$description = $i_description;
		$rating = $i_rating;
    }
	
	function __destruct ()
	{
		//print "product dtor...\n";
	}
}