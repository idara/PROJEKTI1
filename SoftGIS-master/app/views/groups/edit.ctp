<!-- Ryhmähallinta - Muokkaa ryhmiä -->
 
<?php
	echo $this->element('authors_menu');
?>

<h3><?php __('Muokkaa ryhmän nimeä'); ?></h3><br>


<?php
	echo $this->Session->flash('auth');
    echo $this->Form->create('Group');
    echo $this->Form->input('groupname', array('label' => __('Ryhmän nimi', true), 'title' => __('Rhmän nimen on oltava vähintään 3 merkkiä pitkä', true)));
?>

<!-- Tallenna muutokset -->
<button type="submit"><?php __('Tallenna muutokset'); ?></button>

<!-- Hylkää muutokset -->
<?php
	echo $this->Html->link(
		__('Peruuta', true),
		array('controller' => 'groups', 'action' => 'index'),
		array('class' => 'button cancel')
	);
?>
<?php echo $this->Form->end(); ?>
