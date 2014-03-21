<!-- Käyttäjähallinta - omien tietojen näyttö -->
<?php
	echo $this->element('profile_header');
?>


<div class="profileContent">

	<div class="profileBasicInfo">
		<h3><?php echo $author['0']['authors']['username']; ?></h3>
		<p>
			<?php 
				$i=(intval($author['0']['authors']['group_id'])-1);
				echo $groups[$i]['Group']['groupname'];
			?>
		</p>
		
		<div class="profileElementRight">
			<!-- Linkki käyttäjänimen muokkaamiseen -->
			<?php
				echo $this->Html->link(
					__('Käyttäjänimi', true),
					array(
						'controller' => 'authors',
						'action' => 'profile_username',
						$author['0']['authors']['id']
					),
					array(
						'class' => 'button small profileEditButton',
						'title' => 'Muokkaa omaa käyttäjätunnustasi'
					)
				);
			?>
			
			<!-- Linkki salasanan muokkaamiseen -->
			<?php
				echo $this->Html->link(
					'Salasana',
					array(
						'controller' => 'authors',
						'action' => 'profile_password',
						$author['0']['authors']['id']
					),
					array(
						'class' => 'button small profileEditButton',
						'title' => 'Vaihda oma salasanasi'
					)
				);
			?>
			
			<!-- Linkki ryhmän muokkaamiseen -->
				<?php
					echo $this->Html->link(
						'Ryhmä',
						array(
							'controller' => 'authors',
							'action' => 'profile_group',
							$author['0']['authors']['id']
						),
						array(
							'class' => 'button small profileEditButton',
							'title' => 'Vaihda ryhmää, johon kuulut'
						)
					);
				?>
					
				<!-- Linkki käyttäjän poistamiseksi -->
				<?php
					echo $this->Html->link(
						'Poista',
						array(
							'controller' => 'authors',
							'action' => 'profile_delete',
							$author['0']['authors']['id']
						),
						array(
							'class' => 'button small profileEditButton',
							'title' => 'Poista oma käyttäjätunnuksesi ja kaikki kyselysi'
						),
						sprintf("Haluatko varmasti poistaa oman käyttäjätunnuksesi '%s'?", $author['0']['authors']['username'])
						//$confirmMessage
					);
				?>
		</div>
		
	</div>
	
	<h4>Kyselyitä</h4>
	<div class="profileSpecialInfo">
		<div class="profileSpecialInfofield">
			<h4>
				Yhteensä
				<?php
					echo $this->Html->image(
						'information.png',
						array(
							'alt' => 'CakePHP',
							'class' => 'infoIcon',
							'title' => 'Käyttäjän kaikkien kyselyiden yhteismäärä'
						)
					);
				?>
			</h4>
			<p class="profileSpecialInfofieldIndent">
				<?php // Käyttäjän kyselyiden määrä
					echo ($pollsCount['0']['0']['lkm'])
				?>
			</p>
		</div>
	
		<div class="profileSpecialInfofield">
			<h4>
				Julkisia
				<?php
					echo $this->Html->image(
						'information.png',
						array(
							'alt' => 'CakePHP',
							'class' => 'infoIcon',
							'title' => 'Käyttäjän julkisten kyselyiden määrä'
						)
					);
				?>
			</h4>
			<p class="profileSpecialInfofieldIndent">
				<?php // Käyttäjän julkisten kyselyiden määrä
					echo ($publicPollsCount['0']['0']['lkm'])
				?>
			</p>
		</div>
		
		<div class="profileSpecialInfofield">
			<h4>
				Aktiivisia
				<?php
					echo $this->Html->image(
						'information.png',
						array(
							'alt' => 'CakePHP',
							'class' => 'infoIcon',
							'title' => 'Käyttäjän avoimien kyselyiden määrä'
						)
					);
				?>
			</h4>
			<p class="profileSpecialInfofieldIndent">
				<?php // Käyttäjän julkisten kyselyiden määrä
					echo ($openPollsCount['0']['0']['lkm'])
				?>
			</p>
		</div>
	</div>
</div>