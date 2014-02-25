<!-- Käyttäjähallinta - listaa kaikki käyttäjät ja käyttäjien oikeudet -->
 
<?php
	echo $this->element('authors_menu');
?>

 
<hr>

<h2>Käyttäjähallinta - Käyttäjien oikeudet</h2>

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
			<th>Toiminnot</th>
        </tr>
    </thead>
	<tbody>
        <?php foreach ($authors as $author): ?>
            <tr>
                <td><?php echo $author['Author']['id']; ?></td>
				<td><?php echo $author['Author']['username']; ?></td>
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