<!-- Käyttäjähallinta - valikko -->
 
<?php
	echo $this->Html->link(
		'Näytä kaikki käyttäjät',
		array(
			'controller' => 'authors',
			'action' => 'view'
		),
		array(
			'class' => 'button',
			'title' => 'Lisää uusi käyttäjä järjestelmään.'
		)
	);
?>

<?php
	echo $this->Html->link(
		'Lisää uusi käyttäjä',
		array(
			'controller' => 'authors',
			'action' => 'add'
		),
		array(
			'class' => 'button',
			'title' => 'Lisää uusi käyttäjä järjestelmään.'
		)
	);
?>