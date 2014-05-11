<!-- Käyttäjähallinta - listaa kaikki käyttäjät -->
 
<?php
	echo $this->element('authors_menu');
?>

<h3><?php echo (__('Vaihda käyttäjän', true) . " " . $user['Author']['username'] . " " . __('käyttäjätunnus', true)); ?></h3><br>

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
    echo $this->Form->input('username', array('label' => __('Käyttäjätunnus', true), 'autofocus' => 'autofocus', 'title' => __('Käyttäjätunnuksen on oltava vähintään 3 merkkiä pitkä.', true), 'after'=> '<span class="afterInput">' . __('Syötä uusi käyttäjätunnus.', true) . '</span>'));
	
	echo ("<br><br>");
	
	echo $this->Form->input('confirmPassword', array('type'=>'password', 'label' => __('Syötä salasanasi', true), 'after'=> '<span class="afterInput">' . __('Turvallisuussyistä johtuen, syötä salasanasi vahvistaaksesi muutokset.', true) . '</span>'));
?>
<br>

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