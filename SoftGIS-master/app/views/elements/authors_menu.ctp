<!-- Käyttäjähallinta - valikko -->

<h2><?php __('Käyttäjähallinta'); ?></h2>


 
<?php
	echo $this->Html->link(
		__('Näytä käyttäjät', true),
		array(
			'controller' => 'authors',
			'action' => 'view'
		),
		array(
			'class' => 'button',
			'title' => __('Näytä kaikki käyttäjät', true)
		)
	);
?>

<?php
	echo $this->Html->link(
		__('Lisää käyttäjä', true),
		array(
			'controller' => 'authors',
			'action' => 'add'
		),
		array(
			'class' => 'button',
			'title' => __('Lisää uusi käyttäjä', true)
		)
	);
?>

<?php
	echo $this->Html->link(
		__('Näytä ryhmät', true),
		array(
			'controller' => 'groups',
			'action' => 'index'
		),
		array(
			'class' => 'button',
			'title' => __('Näytä kaikki ryhmät', true)
		)
	);
?>

<?php
	echo $this->Html->link(
		__('Lisää ryhmä', true),
		array(
			'controller' => 'groups',
			'action' => 'add'
		),
		array(
			'class' => 'button',
			'title' => __('Lisää uusi ryhmä', true)
		)
	);
?>


<hr>