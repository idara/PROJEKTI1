<!-- Käyttäjähallinta - listaa kaikki käyttäjät -->

<?php
	echo $this->element('authors_menu');
?>

<table class="list">
    <thead>
        <tr>
		<!--
            <th>ID</th>
            <th>Käyttäjätunnus</th>
            <th>Toiminnot</th>
		-->
		
			<th><?php echo $this->Paginator->sort('Id', 'id');?></th>
			<th title="Järjestä taulukko käyttäjänimen mukaan"><?php echo $this->Paginator->sort('Käyttäjänimi', 'username');?></th>
			<th title="Järjestä taulukko ryhmän numeron mukaan"><?php echo $this->Paginator->sort('Ryhmä', 'group_id');?></th>
			<!--<th>Ryhmä</th>-->
			<th title="Käyttäjän omien kyselyiden lukumäärä">Kyselyitä</th>
			<th>Muokkaa</th>
			<th>Poista</th>
        </tr>
    </thead>
	<tbody>
        <?php foreach ($authors as $author): ?>
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
							'Käyttäjänimeä',
							array(
								'controller' => 'authors',
								'action' => 'username',
								$author['Author']['id']
							),
							array(
								'class' => 'button small',
								'title' => 'Muokkaa käyttäjänimeä'
							)
						);
					?>
					
					<!-- Linkki käyttäjän muokkaussivulle -->
					<?php
						echo $this->Html->link(
							'Salasanaa',
							array(
								'controller' => 'authors',
								'action' => 'password',
								$author['Author']['id']
							),
							array(
								'class' => 'button small',
								'title' => 'Vaihda käytäjän salasana'
							)
						);
					?>
					
					<!-- Linkki ryhmän muokkaamiseen -->
					<?php
						echo $this->Html->link(
							'Vaihda ryhmää',
							array(
								'controller' => 'authors',
								'action' => 'group',
								$author['Author']['id']
							),
							array(
								'class' => 'button small',
								'title' => 'Vaihda ryhmää, johon käyttäjä kuuluu'
							)
						);
					?>
				</td>			
				<td>
					<!-- Linkki käyttäjän poistamiseksi -->
					<?php
						echo $this->Html->link(
							'Poista',
							array(
								'controller' => 'authors',
								'action' => 'delete',
								$author['Author']['id']
							),
							array(
								'class' => 'button small',
								'title' => 'Poista käyttäjä ja kaikki käyttäjän kyselyt.'
							),
							sprintf("Haluatko varmasti poistaa käyttäjän '%s'?", $author['Author']['username'])
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