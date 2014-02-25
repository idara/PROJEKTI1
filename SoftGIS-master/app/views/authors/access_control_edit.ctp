<!-- Käyttäjähallinta - listaa kaikki käyttäjät -->
 
<?php
	echo $this->element('authors_menu');
?>
 
<hr>

<h2>Käyttäjähallinta - Muokkaa käyttäjän hallintaoikeutta</h2>


<?php

	echo $this->Session->flash('auth');
    echo $this->Form->create('Author');
	
	//echo $this->Form->label($author_username);
	
	//echo ($user['Author']['username'] . " - " . $user['Author']['id']);

	
    //echo $this->Form->input('username', array('label' => 'Käyttäjänimi', 'title' => 'Käyttäjänimen on oltava vähintään 3 merkkiä pitkä.'));

	echo("<br>");
	
	$options=array('0' => 'Ei', '1' => 'Kyllä');
	$attributes=array('legend'=>'Hallintaoikeus', 'separator'=>'<br>');
	echo $this->Form->radio('accessControl',$options,$attributes, array( 'label' => 'Hallintaoikeus' ));

	echo("<br>");

?>

<!-- Tallenna muutokset -->
<button type="submit">Tallenna muutokset</button>

<!-- Hylkää muutokset -->
<?php
	echo $this->Html->link(
		'Peruuta',
		array('controller' => 'authors', 'action' => 'view'),
		array('class' => 'button cancel')
	);
?>
<?php echo $this->Form->end(); ?>
