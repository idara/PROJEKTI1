<!-- Käyttäjähallinta - listaa kaikki käyttäjät -->
 
<?php
	echo $this->element('authors_menu');
?>


<?php
	echo $this->Session->flash('auth');
    echo $this->Form->create('Author');
	echo ("<label class=\"labelfix\">Muokkaa käyttäjän " . $user['Author']['username'] . " käyttäjänimeä</label>");
    echo $this->Form->input('username', array('label' => false, 'title' => 'Käyttäjänimen on oltava vähintään 3 merkkiä pitkä.'));
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
