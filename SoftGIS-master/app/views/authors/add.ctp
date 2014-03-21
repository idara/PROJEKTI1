<!-- Käyttäjähallinta - lisää käyttäjä -->

<?php
	echo $this->element('authors_menu');
?>

<!-- Lomake käyttäjän luomiselle -->
<?php
	
    echo $this->Session->flash('auth');
    echo $this->Form->create('Author');
    echo $this->Form->input('username', array('label' => __('Käyttäjänimi', true), 'title' => __('Käyttäjänimen on oltava vähintään 3 merkkiä pitkä', true)));
    echo $this->Form->input('password', array('label' => __('Salasana', true)));

	//Luodaan select -elementille asetukset
	$options = array();
	//foreach ($groups as $group)// Poista kommentit tältä riviltä ja kommentoi alla oleva rivi, niin saat Select-elementin valinnat käänteiseen järjestykseen. Tarkista myös silmukan sisältö
	for($i=(count($groups)-1);$i>=0;$i--)
	{
		//$options[$group['Group']['id']] = $group['Group']['groupname'];// Poista kommentit tältä riviltä ja kommentoi alla oleva rivi, niin saat Select-elementin valinnat käänteiseen järjestykseen. Tarkista myös silmukan alku (for / foreach)
		$options[$groups[$i]['Group']['id']] = $groups[$i]['Group']['groupname'];
	}
	//Select elementille otsikko
	echo ("<label class=\"labelfix\">" . __('Valitse ryhmä käyttäjälle', true) . "</label>");
	//Select-elementti
	echo $this->Form->select('group_id', $options, null, array('empty' => false));
	
	echo("<br><br>");
?>
<!-- Tallenna muutokset -->
<button type="submit"><?php __('Lisää käyttäjä'); ?></button>

<!-- Hylkää muutokset -->
<?php
	echo $this->Html->link(
		__('Peruuta', true),
		array('controller' => 'authors', 'action' => 'view'),
		array('class' => 'button cancel')
	);
?>
<?php echo $this->Form->end(); ?>
