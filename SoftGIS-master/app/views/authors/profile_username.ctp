<!-- Käyttäjähallinta - listaa kaikki käyttäjät -->
 
<?php
	echo $this->element('profile_header');	
?>

<h3><?php echo (__('Vaihda käyttäjän', true) . " " . $user['Author']['username'] . " " . __('käyttäjätunnus', true)); ?></h3><br>

<?php
	echo $this->Session->flash('auth');
    echo $this->Form->create('Author');
    echo $this->Form->input('username', array('label' => __('Käyttäjätunnus', true), 'title' > __('Käyttäjätunnuksen on oltava vähintään 3 merkkiä pitkä.', true)));
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