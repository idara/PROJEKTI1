<!-- Käyttäjähallinta - listaa kaikki käyttäjät -->
 
<?php
	echo $this->element('profile_header');	
?>


<?php
	echo $this->Session->flash('auth');
    echo $this->Form->create('Author');
	echo ("<label class=\"labelfix\">" . __('Muokkaa käyttäjän', true) . " " . $user['Author']['username'] . " " . __('käyttäjänimeä', true) . "</label>");
    echo $this->Form->input('username', array('label' => false, 'title' => __('Käyttäjänimen on oltava vähintään 3 merkkiä pitkä.', true)));
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