<!-- Käyttäjähallinta - listaa kaikki käyttäjät -->

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
		
		//Delete user and all user's polls
		$( "#deleteDialog" ).dialog({
			autoOpen: false,
			resizable: false,
			modal: true,
			buttons: {
				"Poista": function() {
					
					dataConfirmPassword = $('#passwordConfirm').val();
				
					var form = $('<form action="' + dataHref + '" method="post">' + 
					'<input type="hidden" name="confirmPassword" value="' + dataConfirmPassword + '" />' + 
					'</form>');
					
					$('body').append(form);
					$(form).submit();
					
					$( this ).dialog( "close" );
				},
				"Peruuta": function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
		$( ".deleteOpener" ).click(function(event) {
			$( ".userDataUsername" ).empty();
			
			dataUsername = $(this).attr('uname');
			dataHref = $(this).attr('href');
			
			$("#deleteDialog .userDataUsername").text(dataUsername);
			
			$( "#deleteDialog" ).dialog( "open" );
			event.preventDefault();
		});
		
	});
</script>

<?php
	echo $this->element('authors_menu');
?>

<!-- Deletedialog -->
<div id="deleteDialog" class="usermanagementPopup" title="<?php __('Vahvista poisto'); ?>">
	<p>
		<?php __('Käyttäjätunnus'); ?>: <span class="userDataUsername"></span><br>
	</p><br>
	<p>
		<?php __('Haluatko varmasti poistaa käyttäjätunnuksen ja kaikki käyttäjän kyselyt?'); ?>
	</p><br>
	
	<!-- Confirmation with editor's password -->
	<div class="input text required">
		<label for="passwordConfirm"><?php __('Vahvista salasanallasi'); ?></label>
		<input type="password" id="passwordConfirm" title="<?php __('Syötä salasanasi vahvistaaksesi muutosoikeutesi'); ?>"/>
	</div>
</div>


<h3><?php __('Käyttäjät'); ?></h3><br>

<table class="list">
    <thead>
        <tr>
			<th><?php echo $this->Paginator->sort('Id', 'id');?></th>
			<th><?php echo $this->Paginator->sort(__('Käyttäjänimi', true), 'username');?></th>
			<th><?php echo $this->Paginator->sort(__('Sähköposti', true), 'email');?></th>
			<th><?php echo $this->Paginator->sort(__('Ryhmä', true), 'group_id');?></th>
			<th><?php __('Kyselyitä'); ?></th>
			<th><?php __('Muokkaa'); ?></th>
			<th><?php __('Poista'); ?></th>
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
					
					//Email
					$emailTitleString = __("Vaihda oma sähköpostiosoitteesi", true);
					
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
					
					//Email
					$emailTitleString = __("Vaihda käyttäjän sähköpostiosoite", true);
					
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
				<td><?php echo $author['Author']['email']; ?></td>
				<td>
					<?php
						//Käyttäjän ryhmän tulostus
						foreach($groups as $group)
						{
							if($author['Author']['group_id']==$group['groups']['id'])
							{
								echo ($group['groups']['groupname']);
							}
						}
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
					/*
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
					*/
					?>
					
					<!-- Linkki salasanan muokkaussivulle -->
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
					
					<!-- Linkki sähköpostin muokkaussivulle -->
					<?php
						echo $this->Html->link(
							__('Sähköposti', true),
							array(
								'controller' => 'authors',
								'action' => 'email',
								$author['Author']['id']
							),
							array(
								'class' => 'button small',
								'title' => $emailTitleString
							)
						);
					?>
					
					<!-- Linkki ryhmän muokkaamiseen -->
					<?php
						echo $this->Html->link(
							__('Ryhmä', true),
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
								'class' => 'deleteOpener button small',
								'title' => $deleteTitleString,
								'userid' => $author['Author']['id'],
								'uname' => $author['Author']['username']
							)
						);
					?>
				</td>
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