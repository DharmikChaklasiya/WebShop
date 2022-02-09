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
class order
{
	$id;
	$date;
	$user;
	$voucher;
	$items;	
	
	function __construct ()
	{
		//print "empty order ctor...\n";
		$id = '';
		$date = '';
		$user = '';
		$voucher = '';
		$items = array();
    }
	
	function __construct ($i_id, $i_date, $i_user, $i_voucher, $i_items)
	{
		//print "param order ctor...\n";
		$id = $i_id;
		$date = $i_date;
		$user = $i_user;
		$voucher = $i_voucher;
		$items = $i_items;
    }
	
	function __destruct ()
	{
		//print "order dtor...\n";
	}
	
	function addItem ($i_item)
	{
		array_push($items, $i_item);
	}
	
	function removeItem ($i_item)
	{
		//unset($array[1]);
		//array_push($items, $i_item);
	}
}

class item
{
	$id;
	$product;
	$count;
	
	function __construct ()
	{
		//print "empty item ctor...\n";
		$id = '';
		$product = '';
		$count = '';
    }
	
	function __construct ($i_id, $i_product, $i_count)
	{
		//print "param item ctor...\n";
		$id = $i_id;
		$product = $i_product;
		$user = $i_user;
		$count = $i_count;
    }
	
	function __destruct ()
	{
		//print "item dtor...\n";
	}
}
?>