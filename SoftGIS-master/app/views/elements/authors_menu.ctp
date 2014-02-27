<!-- Käyttäjähallinta - valikko -->

<h2>Käyttäjähallinta</h2>


 
<?php
	echo $this->Html->link(
		'Näytä käyttäjät',
		array(
			'controller' => 'authors',
			'action' => 'view'
		),
		array(
			'class' => 'button',
			'title' => 'Näytä kaikki käyttäjät'
		)
	);
?>

<?php
	echo $this->Html->link(
		'Lisää käyttäjä',
		array(
			'controller' => 'authors',
			'action' => 'add'
		),
		array(
			'class' => 'button',
			'title' => 'Lisää uusi käyttäjä'
		)
	);
?>

<?php
	echo $this->Html->link(
		'Näytä ryhmät',
		array(
			'controller' => 'groups',
			'action' => 'index'
		),
		array(
			'class' => 'button',
			'title' => 'Näytä kaikki ryhmät'
		)
	);
?>

<?php
	echo $this->Html->link(
		'Lisää ryhmä',
		array(
			'controller' => 'groups',
			'action' => 'add'
		),
		array(
			'class' => 'button',
			'title' => 'Lisää uusi ryhmä'
		)
	);
?>

<hr>
<br>