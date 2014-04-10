<!-- Ryhmähallinta - Muokkaa ryhmiä -->
 
<?php
	echo $this->element('authors_menu');
?>

<h3><?php __('Muokkaa ryhmän nimeä'); ?></h3><br>


<?php
	echo $this->Session->flash('auth');
    echo $this->Form->create('Group');
    echo $this->Form->input('groupname', array('label' => __('Ryhmän nimi', true), 'title' => __('Ryhmän nimen on oltava vähintään 3 merkkiä pitkä', true), 'after'=> '<span class="afterInput">' . __('Syötä ryhmän uusi nimi.', true) . '</span>'));
	
	echo ("<br><br>");
	
	echo $this->Form->input('confirmPassword', array('type'=>'password', 'label' => __('Syötä salasanasi', true), 'after'=> '<span class="afterInput">' . __('Turvallisuussyistä johtuen, syötä salasanasi vahvistaaksesi muutokset.', true) . '</span>'));
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
