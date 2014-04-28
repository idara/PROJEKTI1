<script>	
	
	$( document ).ready(function() {
	
		var dataId;
		var dataUsername;
		var dataHref;
		var dataConfirmPassword;
	
		//Title -> tooltip
		$('a[title]').qtip({
			show: {
				delay: 300
			},
			position: {
				my: "bottom center",
				at: "top center"
				// my: "right center",
				// at: "left center"
			},
			style: {
				classes: "ui-tooltip-help ui-tooltip-shadow"
			}
		});		
	});
</script>

<!-- Käyttäjähallinta - omien tietojen näyttö -->
<?php
	echo $this->element('profile_header');
?>


<div class="profileContent">

	<div class="profileBasicInfo">
		<h3><?php echo $author['0']['authors']['username']; ?></h3>
		<p>
			<?php
				//Käyttäjän ryhmän tulostus
				foreach($groups as $group)
				{
					if($author['0']['authors']['group_id']==$group['groups']['id'])
					{
						echo ($group['groups']['groupname']);
					}
				}
			?>
		</p>
		
		<div class="profileElementRight">
			<!-- Linkki käyttäjänimen muokkaamiseen -->
			<?php
			/*
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
				*/
			?>
			
			<!-- Linkki salasanan muokkaamiseen -->
			<?php
				echo $this->Html->link(
					__('Vaihda salasana', true),
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
				/*
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
				*/
				?>
					
				<!-- Linkki käyttäjän poistamiseksi -->
				<?php
				/*
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
					*/
				?>
				
				<!-- Linkki tukipyynnön jättämiseen -->
				<?php
					echo $this->Html->link(
						__('Tukipyyntö', true),
						array(
							'controller' => 'requests',
							'action' => 'add'
						),
						array(
							'class' => 'button small profileEditButton',
							'title' => __('Jätä tukipyyntö järjestelmänvalvojalle', true)
						)
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
							'title' => __('Käyttäjän kaikkien kyselyiden yhteismäärä', true)
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
							'title' => __('Käyttäjän julkisten kyselyiden määrä', true)
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
							'title' => __('Käyttäjän avoimien kyselyiden määrä', true)
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