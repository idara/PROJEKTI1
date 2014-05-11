<!-- Käyttäjähallinta - valikko -->

<h2><?php __('Käyttäjähallinta'); ?></h2>


 
<?php
	echo $this->Html->link(
		__('Käyttäjät', true),
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
		__('Ryhmät', true),
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

<?php
	echo $this->Html->link(
		__('Avoimet tukipyynnöt', true),
		array(
			'controller' => 'requests',
			'action' => 'index'
		),
		array(
			'class' => 'button',
			'title' => __('Näytä avoimet tukipyynnöt', true)
		)
	);
?>

<?php
	echo $this->Html->link(
		__('Käsitellyt tukipyynnöt', true),
		array(
			'controller' => 'requests',
			'action' => 'viewcomplited'
		),
		array(
			'class' => 'button',
			'title' => __('Näytä käsitellyt tukipyynnöt', true)
		)
	);
?>

<?php
	echo $this->Html->link(
		__('Varmuuskopiointi', true),
		array(
			'controller' => 'authors',
			'action' => 'backup'
		),
		array(
			'class' => 'button',
			'title' => __('Datan varmuuskopiointi', true)
		)
	);
?>

<hr>