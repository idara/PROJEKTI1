<!-- Käyttäjähallinta - listaa kaikki käyttäjät -->
 
<?php
	echo $this->element('authors_menu');
?>
 
<hr>

<h2>Käyttäjähallinta - Muokkaa käyttäjää</h2>


<?php
	echo $this->Session->flash('auth');
    echo $this->Form->create('Author');
    echo $this->Form->input('username', array('label' => 'Käyttäjänimi', 'title' => 'Käyttäjänimen on oltava vähintään 3 merkkiä pitkä.'));
    echo $this->Form->input('password', array('label' => 'Salasana'));
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
