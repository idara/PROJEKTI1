<!-- Ryhmähallinta - Muokkaa ryhmiä -->
 
<?php
	echo $this->element('authors_menu');
?>
 
<hr>

<h2>Ryhmähallinta - Muokkaa ryhmää</h2>


<?php
	echo $this->Session->flash('auth');
    echo $this->Form->create('Group');
    echo $this->Form->input('groupname', array('label' => 'Ryhmän nimi', 'title' => 'Rhmän nimen on oltava vähintään 3 merkkiä pitkä.'));
?>

<!-- Tallenna muutokset -->
<button type="submit">Tallenna muutokset</button>

<!-- Hylkää muutokset -->
<?php
	echo $this->Html->link(
		'Peruuta',
		array('controller' => 'groups', 'action' => 'index'),
		array('class' => 'button cancel')
	);
?>
<?php echo $this->Form->end(); ?>
