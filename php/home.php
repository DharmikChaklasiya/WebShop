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

<h2>Welcome!</h2>

<?php
$feedAdresse = "http://www.blumen-abc.net/rss2.php";
$rssFeed = simplexml_load_file($feedAdresse);
//var_dump($rssFeed);

echo "<div>";

// title
echo "<h2>" . $rssFeed->channel->title . "</h2>";

// link
$link = $rssFeed->channel->link;
echo "<a href='$link'>$link</a><br/>";

// description
echo $rssFeed->channel->description;

echo "</div><br/>";

echo "<div id='feed'>";
$idx_entry = 0;
foreach ($rssFeed->channel->item as $entry)
{
	echo '<div style="background-color:' . (($idx_entry%2) ? '#101010' : '#dadada') . '; color:' . (($idx_entry%2) ? 'white' : 'black') . '; padding:1em;">';
	
	echo "<h3>";
	echo $entry->title;
	echo "</h3>";
	//echo $entry->description . "<br/>";
	echo htmlspecialchars($entry->description, ENT_SUBSTITUTE | ENT_DISALLOWED)."<br/>";
	echo "<a href='$entry->link'>Zum Artikel</a><br/>";
	echo "</div>";
	$idx_entry++;
}
?>
</div>