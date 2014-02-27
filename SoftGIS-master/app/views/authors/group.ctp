<!-- Käyttäjähallinta - listaa kaikki käyttäjät -->
 
<?php
	echo $this->element('authors_menu');
?>


<?php
	echo $this->Session->flash('auth');
	
    echo $this->Form->create('Author');
	
	//Luodaan select -elementille asetukset
	$options = array();
	foreach ($groups as $group)
	{
		$options[$group['Group']['id']] = $group['Group']['groupname'];
	}
	
	echo ("<label class=\"labelfix\">Valitse ryhmä käyttäjälle " . $user['Author']['username'] . "</label>");
	
	echo $this->Form->select('group_id', $options, null, array('empty' => false));
	
	echo("<br><br>");
?>

<!-- Tallenna muutokset -->
<button type="submit">Tallenna muutokset</button>

<!-- Hylkää muutokset -->
<?php
	echo $this->Html->link(
		'Peruuta',
		array('controller' => 'authors', 'action' => 'view'),
		array('class' => 'button cancel')
	);
?>
<?php echo $this->Form->end(); ?>