<!-- Käyttäjähallinta - listaa kaikki käyttäjät -->
 
<?php
	echo $this->element('authors_menu');	
?>

<h3><?php echo (__('Vaihda käyttäjän', true) . " " . $user['Author']['username'] . " " . __('salasana', true)); ?></h3><br>

<?php
	echo $this->Session->flash('auth');
    echo $this->Form->create('Author');
    echo $this->Form->input('pwd', array('type'=>'password', 'label' => __('Uusi salasana', true), 'autofocus' => 'autofocus'));
	echo $this->Form->input('retypedPassword', array('type'=>'password', 'label' => __('Vahvista uusi salasana', true), 'title' => __('Vaihtaaksesi salasanan, syötä uusi salasana molempiin kenttiin.', true), 'after' => '<span class="afterInput">Kirjoitusvirheiden ehkäisemiseksi, syötä uusi salasana molempiin kenttiin.</span>'));
	
	echo ("<br><br>");
	
	echo $this->Form->input('confirmPassword', array('type'=>'password', 'label' => __('Syötä nykyinen salasanasi', true), 'after'=> '<span class="afterInput">' . __('Turvallisuussyistä johtuen, syötä salasanasi vahvistaaksesi muutokset.', true) . '</span>'));
?>

<!-- Tallenna muutokset -->
<button type="submit"><?php __('Tallenna muutokset'); ?></button>

<!-- Hylkää muutokset -->
<?php
	echo $this->Html->link(
		__('Peruuta', true),
		array('controller' => 'authors', 'action' => "view"),
		array('class' => 'button cancel')
	);
?>
<?php echo $this->Form->end(); ?>
