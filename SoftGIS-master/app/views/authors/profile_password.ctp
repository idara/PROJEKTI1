<!-- Käyttäjähallinta - listaa kaikki käyttäjät -->
 
<?php
	echo $this->element('profile_header');	
?>

<h3><?php echo (__('Vaihda käyttäjän', true) . " " . $user['Author']['username'] . " " . __('salasana', true)); ?></h3><br>

<?php
	echo $this->Session->flash('auth');
    echo $this->Form->create('Author');
    echo $this->Form->input('pwd', array('label' => __('Uusi salasana', true), 'type'=>'password', 'autofocus' => 'autofocus'));
	echo $this->Form->input('retypedPassword', array('type'=>'password', 'label' => __('Vahvista uusi salasana', true), 'title' => __('Vaihtaaksesi salasanan, syötä uusi salasana molempiin kenttiin.', true), 'after' => '<span class="afterInput">' . __('Kirjoitusvirheiden ehkäisemiseksi, syötä uusi salasana molempiin kenttiin.', true) . '</span>'));
	
	echo ("<br><br>");
	
	echo $this->Form->input('confirmPassword', array('type'=>'password', 'label' => __('Syötä nykyinen salasanasi', true), 'after'=> '<span class="afterInput">' . __('Turvallisuussyistä johtuen, syötä salasanasi vahvistaaksesi muutokset.', true) . '</span>'));
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
