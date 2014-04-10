<!-- Ryhmähallinta - lisää ryhmä -->

<?php
	echo $this->element('authors_menu');
?>

<h3><?php __('Lisää ryhmä'); ?></h3><br>

<!-- Lomake ryhmän luomiselle -->
<?php
    echo $this->Session->flash('auth');
    echo $this->Form->create('Group');
    echo $this->Form->input('groupname', array('label' => __('Ryhmän nimi', true), 'title' => __('Ryhmän nimen on oltava vähintään 3 merkkiä pitkä', true), 'after'=> '<span class="afterInput">' . __('Syötä uuden ryhmän nimi.', true) . '</span>'));
?>
<!-- Tallenna muutokset -->
<button type="submit"><?php __('Lisää ryhmä'); ?></button>

<!-- Hylkää muutokset -->
<?php
	echo $this->Html->link(
		__('Peruuta', true),
		array('controller' => 'groups', 'action' => 'index'),
		array('class' => 'button cancel')
	);
?>
<?php echo $this->Form->end(); ?>
