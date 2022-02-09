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
class cart
{
	private static $initialized = false;
	
	private static function initialize ()
	{
		if (self::$initialized)
		{
			return;
		}
		
		self::$initialized = true;
	}
	
	public static function addToCart($data)
	{
        if (isset($_SESSION['warenkorb']))
		{
            $found = FALSE;
            foreach($_SESSION['warenkorb'] as $key => $val)
			{
                if ($_SESSION['warenkorb'][$key]['produktId'] == $data['produktId'] && $found == FALSE)
				{
                    $_SESSION['warenkorb'][$key]['anzahl'] += $data['anzahl'];
                    $_SESSION['warenkorb'][$key]['price'] = $_SESSION['warenkorb'][$key]['anzahl'] * (float)$data['price'];
                    $found = TRUE;
                }
            }
			
            if($found === FALSE)
            {
                $new = array(
                    "produktId" => $data['produktId'],
                    "anzahl" => $data['anzahl'],
                    "name" => $data['name'],
                    "price" => $data['price'] * (float)$data['anzahl']
                );
                array_push($_SESSION['warenkorb'], $new);
            }
        }
		else
		{
            $_SESSION['warenkorb'][] = array(
                "produktId" => $data['produktId'],
                "anzahl" => $data['anzahl'],
                "name" => $data['name'],
                "price" => $data['anzahl'] * (float)$data['price']
            );
        }
		
        $summe = 0;
        foreach($_SESSION['warenkorb'] as $key => $val)
        {
            $summe += (float)$_SESSION['warenkorb'][$key]['price'];
            echo "<li class=\"list-group-item\"><span class=\"badge\"><span class=\"glyphicon 
            glyphicon-remove remove_item \" data-produkt-id='".$_SESSION['warenkorb'][$key]['produktId']
            ."'></span></span><span class=\"badge count_produkte\">"
                .$_SESSION['warenkorb'][$key]['anzahl']
                ."</span><em>
            "
                .$_SESSION['warenkorb'][$key]['name']
                ."</em><em class='price_badge'>"
                .$_SESSION['warenkorb'][$key]['price']
                ."</em></li>";
        }
        echo "<div class=\"warenkorb_summe\">Summe: ".$summe."</div>";
    }

    public static function removeFromCart ($data)
	{
        foreach($_SESSION['warenkorb'] as $key => $val)
		{
            if($_SESSION['warenkorb'][$key]['produktId'] == $data['produktId'])
			{
                if($this->connect())
				{
                    $result = $this->dbobject->query("SELECT p.preis FROM products p WHERE p.productId = "
                        .$data['produktId']."");
                    while($row = $result->fetch_assoc())
					{
                        $rows[] = $row;
                    }
                }

                $_SESSION['warenkorb'][$key]['anzahl'] -= 1;
                $_SESSION['warenkorb'][$key]['price'] -= $rows[0]['preis'];

                if($_SESSION['warenkorb'][$key]['anzahl'] < 1)
				{
                    unset($_SESSION['warenkorb'][$key]);
                }
            }
        }

        if (count($_SESSION['warenkorb']) > 0)
		{
            $summe = 0;
            foreach($_SESSION['warenkorb'] as $key => $val){
                $summe += (float)$_SESSION['warenkorb'][$key]['price'];
                echo "<li class=\"list-group-item\"><span class=\"badge\"><span class=\"glyphicon 
            glyphicon-remove remove_item \" data-produkt-id='".$_SESSION['warenkorb'][$key]['produktId']
                    ."'></span></span><span 
            class=\"badge count_produkte\">"
                    .$_SESSION['warenkorb'][$key]['anzahl']
                    ."</span><em>
            "
                    .$_SESSION['warenkorb'][$key]['name']
                    ."</em><em class='price_badge'>"
                    .$_SESSION['warenkorb'][$key]['price']
                    ."</em></li>";
            }
            echo "<div>Summe: ".$summe."</div>";
        }
		else
		{
            echo "Keine Produkte im Warenkorb!";
        }
    }
	
	//Function to count the products in the cart
    public static function getCount()
    {
		$count = 0;
        // check if products in the cart		
        if (isset($_SESSION['cart']))
        {
            for ($i = 0; $i < count($_SESSION['cart']); $i++)
            {
                $count += $_SESSION['cart'][$i]['quantity'];
            }
        }
		return $count;
    }
}
?>