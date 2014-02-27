<!-- Ryhmähallinta - lisää ryhmä -->

<?php
	echo $this->element('authors_menu');
?>

<hr>

<h2>Ryhmähallinta - Lisää uusi ryhmä</h2>

<!-- Lomake ryhmän luomiselle -->
<?php
    echo $this->Session->flash('auth');
    echo $this->Form->create('Group');
    echo $this->Form->input('groupname', array('label' => 'Ryhmän nimi', 'title' => 'Rhmän nimen on oltava vähintään 3 merkkiä pitkä.'));
?>
<!-- Tallenna muutokset -->
<button type="submit">Lisää ryhmä</button>

<!-- Hylkää muutokset -->
<?php
	echo $this->Html->link(
		'Peruuta',
		array('controller' => 'groups', 'action' => 'index'),
		array('class' => 'button cancel')
	);
?>
<?php echo $this->Form->end(); ?>
