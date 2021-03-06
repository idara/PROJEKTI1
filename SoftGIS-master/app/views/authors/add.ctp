<!-- Käyttäjähallinta - lisää käyttäjä -->

<?php
	echo $this->element('authors_menu');
?>
<h3><?php __('Lisää käyttäjä'); ?></h3><br>

<!-- Lomake käyttäjän luomiselle -->
<?php
	
    echo $this->Session->flash('auth');
    echo $this->Form->create('Author');
    
	echo $this->Form->input('username', array('label' => __('Käyttäjätunnus', true), 'autofocus' => 'autofocus', 'title' => __('Käyttäjätunnuksen on oltava vähintään 3 merkkiä pitkä', true), 'after'=> '<span class="afterInput">' . __('Syötä uuden käyttäjän käyttäjätunnus.', true) . '</span>'));
	
	echo ("<br><br>");
    
	echo $this->Form->input('pw', array('type'=>'password', 'label' => __('Salasana', true)));
	echo $this->Form->input('passwordRetyped', array('type'=>'password', 'label' => __('Vahvista salasana', true), 'after'=> '<span class="afterInput">' . __('Kirjoitusvirheiden ehkäisemiseksi, syötä salasana molempiin kenttiin.', true) . '</span>'));
	
	echo ("<br><br>");
	
	echo $this->Form->input('email', array('label' => __('Sähköpostiosoite', true)));
	echo $this->Form->input('emailRetyped', array('label' => __('Vahvista sähköpostiosoite', true), 'after'=> '<span class="afterInput">' . __('Kirjoitusvirheiden ehkäisemiseksi, syötä sähköpostiosoite molempiin kenttiin.', true) . '</span>'));
	
	echo ("<br><br>");
	
	//Luodaan select -elementille asetukset
	$options = array();
	//foreach ($groups as $group)// Poista kommentit tältä riviltä ja kommentoi alla oleva rivi, niin saat Select-elementin valinnat käänteiseen järjestykseen. Tarkista myös silmukan sisältö
	for($i=(count($groups)-1);$i>=0;$i--)
	{
		//$options[$group['Group']['id']] = $group['Group']['groupname'];// Poista kommentit tältä riviltä ja kommentoi alla oleva rivi, niin saat Select-elementin valinnat käänteiseen järjestykseen. Tarkista myös silmukan alku (for / foreach)
		$options[$groups[$i]['Group']['id']] = $groups[$i]['Group']['groupname'];
	}
	//Select elementille otsikko
	echo ("<label class=\"labelfix\">" . __('Ryhmä', true) . "</label>");
	//Select-elementti
	echo $this->Form->select('group_id', $options, null, array('empty' => false));
	
	echo("<br><br>");
	echo ("<br><br>");
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
