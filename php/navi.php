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
?>

<nav class="navbar navbar-inverse">
	<div class="container">
	
		<div class="navbar-header">
		
			<h1><a href="index.php" class="left">Funny Flower Fhop</a></h1>
			<div id="navlist">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				
				</button>
			</div>
		</div>
	
		<!--Ist kein User eingeloggt, sind nur die Bereiche „Home“, „Produkte“ und „Warenkorb“ zu sehen
			ii. Ein eingeloggter User sieht die Einträge „Home“, „Produkte“, „Mein Konto“, „Warenkorb“
			iii. Ein Administrator sieht „Home“, „Produkte bearbeiten“, „Kunden bearbeiten“ und „Gutscheine verwalten“
		
		'sections' => loaded from navigation.xml -->

		<div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<?php
					foreach ($config->sections as $section)
					{						
						$section_name = $section;
						$options = '';
						if ($section == "Cart")
						{
							// also add drag and drop functionality:
							$options = 'ondrop="drop(event)" ondragover="allowDrop(event)"';
								
							if ($admin == false &&  isset($_SESSION['cart']))
							{
								$count = 0;
								for ($idx = 0; $idx < count($_SESSION['cart']); $idx++)
								{
									if (isset($_SESSION['cart'][$idx]))
									{
										$count += $_SESSION['cart'][$idx]['quantity'];
									}
								}
								$section_name .= ' ('.$count.')';
							}
						}
						
						$class = '';
						if ($currentSection == $section) $class = ' class="selection"';
						echo '<li'.$class.'><a id="navButton'.$section.'" '.$options.' href="index.php?section='.$section.'">'.$section_name.'</a></li>';
					}
					?>					
				</ul>
			</div>  
		</div>
	</div>
</nav>
