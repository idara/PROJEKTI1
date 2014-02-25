<!-- Käyttäjähallinta - listaa kaikki käyttäjät -->

<?php
	echo $this->element('authors_menu');
?>
 
<hr>

<h2>Käyttäjähallinta - Kaikki järjestelmän käyttäjät</h2>

<table class="list">
    <thead>
        <tr>
		<!--
            <th>ID</th>
            <th>Käyttäjätunnus</th>
            <th>Toiminnot</th>
		-->
		
			<th><?php echo $this->Paginator->sort('Id', 'id');?></th>
			<th><?php echo $this->Paginator->sort('Käyttäjänimi', 'username');?></th>
			<th><?php echo $this->Paginator->sort('Hallintaoikeus', 'accessControl');?></th>
			<th>Toiminnot</th>
        </tr>
    </thead>
	<tbody>
        <?php foreach ($authors as $author): ?>
            <tr>
                <td><?php echo $author['Author']['id']; ?></td>
				<td><?php echo $author['Author']['username']; ?></td>
				<td>
					<?php
						if((($author['Author']['accessControl'])==1) OR ($author['Author']['id'])==1)
						{
							echo ("Kyllä");
						}
						else
						{
							echo ("Ei");
						}
					?>
				</td>
				<td>
					<!-- Linkki käyttäjän muokkaussivulle -->
					<?php
						echo $this->Html->link(
							'Muokkaa',
							array(
								'controller' => 'authors',
								'action' => 'edit',
								$author['Author']['id']
							),
							array(
								'class' => 'button small',
								'title' => 'Muokkaa käyttäjänimeä ja salasanaa.'
							)
						);
					?>
					

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
					
					<!-- Linkki hallintaoikeuksien muokkaamiseen -->
					<?php
						echo $this->Html->link(
							'Muokkaa hallintaoikeutta',
							array(
								'controller' => 'authors',
								'action' => 'access_control_edit',
								$author['Author']['id']
							),
							array(
								'class' => 'button small',
								'title' => 'Muokkaa käyttäjän hallintaoikeutta'
							)
						);
					?>
				</td>
			</tr>
				
		<?php endforeach; ?>
    </tbody>
</table>


<small style="float:right; text-align:right;">
	<?php
		echo $this->Paginator->counter(array( 'format' => __('Sivu %page% / %pages%', true)));
	?>
<br>
		<?php echo $this->Paginator->prev('<< ' . __('edellinen', true), array(), null, array('class'=>'disabled'));?>
	  	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('seuraava', true) . ' >>', array(), null, array('class' => 'disabled'));?>
</small>