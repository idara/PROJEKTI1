<!-- Käyttäjähallinta - vaihda ryhmää -->
 
<?php
	echo $this->element('authors_menu');
?>

<h3><?php echo (__('Vaihda ryhmää, johon käyttäjä', true) . " " . $user['Author']['username'] . " " . __('kuuluu', true)); ?></h3><br>

<?php
	echo $this->Session->flash('auth');
	
    echo $this->Form->create('Author');
	
	//Luodaan select -elementille asetukset
	$options = array();
	foreach ($groups as $group)
	{
		//Karsitaan ylemmän oikeustason ryhmät pois
		if($user['Author']['id']!=$editorsId)
		{
			$options[$group['Group']['id']] = $group['Group']['groupname'];
		}
		elseif($group['Group']['id'] >= $modifyGroup)
		{
			$options[$group['Group']['id']] = $group['Group']['groupname'];
		}
	}
	
	echo ("<label class=\"labelfix\">" . __('Ryhmä', true) . "</label>");
	
	echo $this->Form->select('group_id', $options, null, array('empty' => false));
	
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