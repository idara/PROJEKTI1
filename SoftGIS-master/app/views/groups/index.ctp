<!-- Ryhmähallinta - listaa kaikki ryhmät -->

<?php
	echo $this->element('authors_menu');
?>
 
<hr>

<h2>Ryhmähallinta - Kaikki järjestelmän ryhmät</h2>

<table class="list">
    <thead>
        <tr>		
			<th><?php echo $this->Paginator->sort('Id', 'id');?></th>
			<th><?php echo $this->Paginator->sort('Ryhmän nimi', 'groupname');?></th>
			<th>Toiminnot</th>
        </tr>
    </thead>
	<tbody>
        <?php foreach ($groups as $group): ?>
            <tr>
                <td><?php echo $group['Group']['id']; ?></td>
				<td><?php echo $group['Group']['groupname']; ?></td>
				<td>
					<!-- Linkki ryhmän muokkaussivulle -->
					<?php
						echo $this->Html->link(
							'Muokkaa',
							array(
								'controller' => 'groups',
								'action' => 'edit',
								$group['Group']['id']
							),
							array(
								'class' => 'button small',
								'title' => 'Muokkaa ryhmän nimeä'
							)
						);
					?>
					

					<!-- Linkki ryhmän poistamiseksi -->
					<?php
						echo $this->Html->link(
							'Poista',
							array(
								'controller' => 'groups',
								'action' => 'delete',
								$group['Group']['id']
							),
							array(
								'class' => 'button small',
								'title' => 'Poista ryhmä'
							),
							sprintf("Haluatko varmasti poistaa ryhmän '%s'?", $group['Group']['groupname'])
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