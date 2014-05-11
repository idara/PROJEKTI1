<!-- Ryhmähallinta - listaa kaikki ryhmät -->

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
	
	// Näytä lisää / vähemmän tekstiä
	$(document).ready(function() {
		var showChar = 150;
		var ellipsestext = "...";
		var moretext = "näytä lisää";
		var lesstext = "näytä vähemmän";
		$('.more').each(function() {
			var content = $(this).html();
	 
			if(content.length > showChar) {
	 
				var c = content.substr(0, showChar);
				var h = content.substr(showChar-1, content.length - showChar);
	 
				var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
	 
				$(this).html(html);
			}
	 
		});
	 
		$(".morelink").click(function(){
			if($(this).hasClass("less")) {
				$(this).removeClass("less");
				$(this).html(moretext);
			} else {
				$(this).addClass("less");
				$(this).html(lesstext);
			}
			$(this).parent().prev().toggle();
			$(this).prev().toggle();
			return false;
		});
	});
</script>

<?php
	echo $this->element('authors_menu');
?>

<h3><?php __('Käsitellyt tukipyynnöt'); ?></h3><br>

<table class="list">
    <thead>
        <tr>
			<th><?php __('Käyttäjätunnus'); ?></th>
			<th><?php __('Sähköpostiosoite'); ?></th>
			<th><?php echo $this->Paginator->sort('Tukipyyntö luotu', 'request_created');?></th>
			<th><?php echo $this->Paginator->sort('Tukipyyntö', 'request');?></th>
			<th><?php __('Merkitse'); ?></th>
        </tr>
    </thead>
	<tbody>
        <?php foreach ($requests as $request): ?>
            <tr>
				<td>
					<?php // Tukipyynnön lähettäjän käyttäjänimi
						foreach ($requestors as $requestor)
						{
							if($requestor['requests']['author_id']==$request['Request']['author_id'])
							{
								echo($requestor['authors']['username']);								
							}
						}
					?>
				</td>
				<td>
					<?php // Tukipyynnön lähettäjän käyttäjänimi
						foreach ($requestors as $requestor)
						{
							if($requestor['requests']['author_id']==$request['Request']['author_id'])
							{
								echo($requestor['authors']['email']);								
							}
						}
					?>
				</td>
				<td><?php echo $request['Request']['request_created']; ?></td>
				<td style="text-align:justify;" class="more"><?php echo $request['Request']['request']; ?></td>
				<td>
					<!-- Linkki tilan muuttamiseen -->
					<?php
						echo $this->Html->link(
							__('Käsittelemättömäksi',true),
							array(
								'controller' => 'requests',
								'action' => 'uncomplete',
								$request['Request']['id']
							),
							array(
								'class' => 'button small',
								'title' => __('Merkitse tukipyyntö käsittelemättömäksi',true)
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
		echo $this->Paginator->counter(array( 'format' => __('Sivu', true) . '%page% / %pages%'));
	?>
<br>
		<?php echo $this->Paginator->prev('<< ' . __('edellinen', true), array(), null, array('class'=>'disabled'));?>
	  	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('seuraava', true) . ' >>', array(), null, array('class' => 'disabled'));?>
</small>