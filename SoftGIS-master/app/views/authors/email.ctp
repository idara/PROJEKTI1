<!-- Käyttäjähallinta - muokkaa sähköpostiosoitetta -->
 
<?php
	echo $this->element('authors_menu');
?>

<h3><?php echo (__('Vaihda käyttäjän', true) . " " . $user['Author']['username'] . " " . __('sähköpostiosoite', true)); ?></h3><br>

<?php
/*
	print_r($AuthorizedPassword);
	echo("<br><br>");

	echo ("pwFromDBsql: " . $AuthorizedPassword . "<br>");
	echo ("confirmPassw: " . $confirmPassword . "<br>");
*/
?>

<?php
	echo $this->Session->flash('auth');
    echo $this->Form->create('Author');
    echo $this->Form->input('email', array('label' => __('Sähköpostiosoite', true), 'title' => __('Sähköpostiosoitteen on oltava muotoa erkki@esimerkki.fi.', true)));
	echo $this->Form->input('emailRetyped', array('label' => __('Vahvista sähköpostiosoite', true), 'after'=> '<span class="afterInput">' . __('Kirjoitusvirheiden ehkäisemiseksi, syötä sähköpostiosoite molempiin kenttiin.', true) . '</span>'));
	
	echo ("<br><br>");
	
	echo $this->Form->input('confirmPassword', array('type'=>'password', 'label' => __('Syötä salasanasi', true), 'after'=> '<span class="afterInput">' . __('Turvallisuussyistä johtuen, syötä salasanasi vahvistaaksesi muutokset.', true) . '</span>'));
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