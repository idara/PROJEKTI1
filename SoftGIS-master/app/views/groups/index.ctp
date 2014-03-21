<!-- Ryhmähallinta - listaa kaikki ryhmät -->

<?php
	echo $this->element('authors_menu');
?>

<h3><?php __('Ryhmät'); ?></h3><br>

<table class="list">
    <thead>
        <tr>		
			<th><?php echo $this->Paginator->sort('Id', 'id');?></th>
			<th><?php echo $this->Paginator->sort(__('Ryhmän nimi',true), 'groupname');?></th>
			<th><?php __('Toiminnot'); ?></th>
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
							__('Muokkaa',true),
							array(
								'controller' => 'groups',
								'action' => 'edit',
								$group['Group']['id']
							),
							array(
								'class' => 'button small',
								'title' => __('Muokkaa ryhmän nimeä',true)
							)
						);
					?>
					

					<!-- Linkki ryhmän poistamiseksi -->
					<?php
						$deleteConfirmString = __('Haluatko varmasti poistaa ryhmän',true);
					
						echo $this->Html->link(
							__('Poista',true),
							array(
								'controller' => 'groups',
								'action' => 'delete',
								$group['Group']['id']
							),
							array(
								'class' => 'button small',
								'title' => __('Poista ryhmä',true)
							),
							sprintf("%s '%s'?", $deleteConfirmString, $group['Group']['groupname'])
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