<!-- Käyttäjähallinta - listaa kaikki käyttäjät -->

<?php
	echo $this->element('authors_menu');
	echo ("Kirjautunut käyttäjä: " . $authorizedUserId);
?>

<table class="list">
    <thead>
        <tr>
			<th><?php echo $this->Paginator->sort('Id', 'id');?></th>
			<th title="<?php __('Käyttäjän omien kyselyiden lukumäärä', true); ?>"><?php echo $this->Paginator->sort(__('Käyttäjänimi', true), 'username');?></th>
			<th title="<?php __('Käyttäjän omien kyselyiden lukumäärä', true); ?>"><?php echo $this->Paginator->sort(__('Ryhmä', true), 'group_id');?></th>
			<th title="<?php __('Käyttäjän omien kyselyiden lukumäärä', true); ?>"><?php __('Kyselyitä', true); ?></th>
			<th><?php __('Muokkaa', true); ?></th>
			<th><?php __('Poista', true); ?></th>
        </tr>
    </thead>
	<tbody>
        <?php foreach ($authors as $author): ?>
			<?php
				if(strcmp($author['Author']['id'], $authorizedUserId)==0)
				{
					//Username
					$usernameTitleString = __("Muokkaa omaa käyttäjätunnustasi", true);
					
					//Password
					$passwordTitleString = __("Vaihda oma salasanasi", true);
					
					//Group
					$groupTitleString = __("Vaihda ryhmää, johon kuulut", true);
					
					//Delete
					$deleteTitleString = __("Poista oma käyttäjätunnuksesi ja kaikki kyselysi", true);
					$deleteconfirmString = __("Haluatko varmasti poistaa oman käyttäjätunnuksesi", true);
				}
				else
				{
					
					//Username
					$usernameTitleString = __("Muokkaa käyttäjätunnusta", true);
					
					//Password
					$passwordTitleString = __("Vaihda käyttäjän salasana", true);
					
					//Group
					$groupTitleString = __("Vaihda ryhmää, johon käyttäjä kuuluu", true);
					
					//Delete
					$deleteTitleString = __("Poista käyttäjä ja kaikki käyttäjän kyselyt", true);
					$deleteconfirmString = __("Haluatko varmasti poistaa käyttäjän", true);
				}
			?>
            <tr>
                <td><?php echo $author['Author']['id']; ?></td>
				<td><?php echo $author['Author']['username']; ?></td>
				<td>
					<?php
						//Käyttäjän ryhmän tulostus
						$i=(intval($author['Author']['group_id'])-1);
						echo $groups[$i]['Group']['groupname'];
					?>
				</td>
				<td>
					<?php // Käyttäjän kyselyiden määrä
						foreach ($pollsCount as $pollCount)
						{
							if($pollCount['authors']['id']==$author['Author']['id'])
							{
								echo($pollCount['0']['lkm']);
							}
						}
					?>
				</td>
				<td>
					<!-- Linkki käyttäjätunnuksen muokkaussivulle -->
					<?php
						echo $this->Html->link(
							__('Käyttäjätunnus', true),
							array(
								'controller' => 'authors',
								'action' => 'username',
								$author['Author']['id']
							),
							array(
								'class' => 'button small',
								'title' => $usernameTitleString
							)
						);
					?>
					
					<!-- Linkki käyttäjän muokkaussivulle -->
					<?php
						echo $this->Html->link(
							__('Salasana', true),
							array(
								'controller' => 'authors',
								'action' => 'password',
								$author['Author']['id']
							),
							array(
								'class' => 'button small',
								'title' => $passwordTitleString
							)
						);
					?>
					
					<!-- Linkki ryhmän muokkaamiseen -->
					<?php
						echo $this->Html->link(
							__('Vaihda ryhmää', true),
							array(
								'controller' => 'authors',
								'action' => 'group',
								$author['Author']['id']
							),
							array(
								'class' => 'button small',
								'title' => $groupTitleString
							)
						);
					?>					
				</td>			
				<td>
					<!-- Linkki käyttäjän poistamiseksi -->
					<?php
						echo $this->Html->link(
							__('Poista', true),
							array(
								'controller' => 'authors',
								'action' => 'delete',
								$author['Author']['id']
							),
							array(
								'class' => 'button small',
								'title' => $deleteTitleString
							),
							sprintf("%s '%s'?",$deleteconfirmString, $author['Author']['username'])
							//$confirmMessage
						);
					?>
			</tr>
				
		<?php endforeach; ?>
    </tbody>
</table>


<small class="pageChanger">
<br>
		<?php echo $this->Paginator->prev('<< ' . __('edellinen', true), array(), null, array('class'=>'disabled'));?>
	  	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('seuraava', true) . ' >>', array(), null, array('class' => 'disabled'));?>
</small>