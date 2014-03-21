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
						'title' => __('Muokkaa omaa käyttäjätunnustasi', true)
					)
				);
			?>
			
			<!-- Linkki salasanan muokkaamiseen -->
			<?php
				echo $this->Html->link(
					__('Salasana', true),
					array(
						'controller' => 'authors',
						'action' => 'profile_password',
						$author['0']['authors']['id']
					),
					array(
						'class' => 'button small profileEditButton',
						'title' => __('Vaihda oma salasanasi', true)
					)
				);
			?>
			
			<!-- Linkki ryhmän muokkaamiseen -->
				<?php
					echo $this->Html->link(
						__('Ryhmä', true),
						array(
							'controller' => 'authors',
							'action' => 'profile_group',
							$author['0']['authors']['id']
						),
						array(
							'class' => 'button small profileEditButton',
							'title' => __('Vaihda ryhmää, johon kuulut', true)
						)
					);
				?>
					
				<!-- Linkki käyttäjän poistamiseksi -->
				<?php
					$deleteConfirmString = __('Haluatko varmasti poistaa oman käyttäjätunnuksesi',true);
				
					echo $this->Html->link(
						__('Poista', true),
						array(
							'controller' => 'authors',
							'action' => 'profile_delete',
							$author['0']['authors']['id']
						),
						array(
							'class' => 'button small profileEditButton',
							'title' => __('Poista oma käyttäjätunnuksesi ja kaikki kyselysi', true)
						),
						sprintf("%s '%s'?", $deleteConfirmString, $author['0']['authors']['username'])
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
						'information-icon.png',
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
						'information-icon.png',
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
						'information-icon.png',
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