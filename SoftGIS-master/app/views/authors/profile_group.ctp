<!-- Käyttäjähallinta - vaihda ryhmää -->
 
<?php
	echo $this->element('profile_header');	
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
	
	echo ("<label class=\"labelfix\">" . __('Valitse ryhmä käyttäjälle', true) . " " . $user['Author']['username'] . "</label>");
	
	echo $this->Form->select('group_id', $options, null, array('empty' => false));
	
	echo("<br><br>");
?>

<!-- Tallenna muutokset -->
<button type="submit"><?php __('Tallenna muutokset'); ?></button>

<!-- Hylkää muutokset -->
<?php
	echo $this->Html->link(
		__('Peruuta', true),
		array('controller' => 'authors', 'action' => "profile"),
		array('class' => 'button cancel')
	);
?>
<?php echo $this->Form->end(); ?>