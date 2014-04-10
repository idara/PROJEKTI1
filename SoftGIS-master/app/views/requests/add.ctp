<!-- Ryhmähallinta - lisää ryhmä -->
<script>	
	
	$( document ).ready(function() {
	
	// Tooltip
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
	// Character counter
	//http://spyrestudios.com/building-a-live-textarea-character-count-limit-with-css3-and-jquery/
		  var limitnum = 65535; // set your int limit for max number of characters
  
		  function limiting(obj, limit) {
			var cnt = $("#counter > span");
			var txt = $(obj).val(); 
			var len = txt.length;
			
			// check if the current length is over the limit
			if(len > limit){
			   $(obj).val(txt.substr(0,limit));
			   $(cnt).html(len-1);
			 } 
			 else { 
			   $(cnt).html(len);
			 }
			 
			 // check if user has less than 20 chars left
			 if(limit-len <= 20) {
				$(cnt).addClass("warning");
			 }
		  }


		  $('textarea').keyup(function(){
			limiting($(this), limitnum);
		  });
	});
</script>

<?php
	echo $this->element('profile_header');
?>

<h3><?php __('Lähetä tukipyyntö'); ?></h3><br>

<!-- Lomake ryhmän luomiselle -->
<?php
	$textareaLabel = __('Tukipyyntösi', true) . "<span id=\"counter\" style=\"float:right;\"><span>0</span> / 65535</span>";

    echo $this->Session->flash('auth');
    echo $this->Form->create('Request');
    echo $this->Form->input('request', 
		array(
			'label' => $textareaLabel, 
			'title' => __('Tukipyynnön on oltava vähintään 10 merkkiä pitkä', true), 
			'type' => 'text', 
			'rows' => '10', 'cols' => '1'
		)
	);
	echo $this->Form->hidden('author_id', 
		array(
			'label' => 'Author ID', 
			'type' => 'text',
			'value' => $AuthorizedUserId
		)
	);
	echo $this->Form->hidden('request_created', 
		array(
			'label' => 'Request created', 
			'type' => 'text',
			'value' => $timestamp
		)
	);
?>


<!-- Tallenna muutokset -->
<button type="submit"><?php __('Lähetä'); ?></button>

<!-- Hylkää muutokset -->
<?php
	echo $this->Html->link(
		__('Peruuta', true),
		array('controller' => 'authors', 'action' => 'profile'),
		array('class' => 'button cancel')
	);
?>
<?php echo $this->Form->end(); ?>
