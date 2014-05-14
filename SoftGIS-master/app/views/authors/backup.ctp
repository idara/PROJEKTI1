<!-- Käyttäjähallinta - Varmuuskopiointi -->
 
<?php
	echo $this->element('authors_menu');
?>

<h3>
	<?php
		echo (__('Varmuuskopiointi', true));
		
		echo $this->Html->link(
		__('Luo uusi varmuuskopio', true),
		array('controller' => 'authors', 'action' => "backup_exec"),
		array('class' => 'button small right')
	);
	?>
</h3>
<br><br>
<?php
	$path = WWW_ROOT . "backups" . DIRECTORY_SEPARATOR;
	$downloadPath = $this->webroot . "backups/";
	$filesInOrder = array();

	echo "<table class=\"list\">";
	echo ("<tr>");
	//echo ("<th>" . __('Id', true) . "</th>");
	echo ("<th>" . __('Varmuuskopio luotu', true) . "</th>");
	echo ("<th>" . __('Tiedostokoko', true) . "</th>");
	echo ("<th>" . __('Toimet', true) . "</th>");
	echo ("<tr>");
	
	foreach (glob("$path*.*") as $file)
	{
		$filesInOrder[filemtime($file)] = $file;
	}
	
	// sort
	krsort($filesInOrder);

	//$i = 1;
	foreach($filesInOrder as $file)
	{
		$fileSize = round((filesize($file) / 1024 / 1024), 2);
		$fileName = basename($file);
		
		echo ("<tr>\n");
			//echo ("<td>" . $i . "</td>");
			echo ("<td>" .  date ("d.m.Y H:i:s", filemtime($file)) . "</td>");
			echo ("<td>" . $fileSize . " Mt</td>\n");
			echo ("<td>");
				echo ("<a href=\"" . $downloadPath . $fileName. "\" class=\"button small\" title=\"__('Lataa varmuuskopio palvelimelta', true)\">__('Lataa', true)</a>");
				echo(" ");
				echo $this->Html->link(
							__('Poista', true),
							array(
								'controller' => 'authors',
								'action' => 'backup_delete',
								$fileName
							),
							array(
								'class' => 'button small',
								'title' => __('Poista varmuuskopio palvelimelta', true)
							)
						);
			echo ("</td>\n");
		echo ("</tr>\n");
		
		//$i++;
	}
	echo "</table>";
?>
