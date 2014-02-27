<!-- Käyttäjähallinta - listaa kaikki käyttäjät -->
 
<?php
	echo $this->element('authors_menu');
?>


<?php
	echo $this->Session->flash('auth');
    echo $this->Form->create('Author');
	echo ("<label class=\"labelfix\">Muokkaa käyttäjän " . $user['Author']['username'] . " salasanaa</label>");
    echo $this->Form->input('password', array('label' => false, 'title' => 'Älä tallenna muokkaamatonta salasanaa!'));
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
