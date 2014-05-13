<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php __('SoftGIS'); ?>
        <?php echo $title_for_layout; ?>
    </title>
	
	<?php
		$locale = Configure::read('Config.language');
	?>
	<link rel="gettext" type="application/x-po" href="<?php echo ($this->webroot . 'js/locale/' . $locale . '/LC_MESSAGES/js-default.po'); ?>"/>

    <?php
        echo $this->Html->meta('icon');

        // echo $this->Html->css('cake.generic');
        echo $this->Html->css('poll');
        echo $this->Html->css('jquery.qtip.min');
        echo $this->Html->css('jquery-ui-1.8.14.custom');
        // echo $this->Html->css('jquery.meow');
        // echo $this->Html->css('smoke');
        echo $this->Html->css('token-input');
        echo $this->Html->css('ui.spinner');
		echo $this->Html->css('popup');
        
        echo $this->Html->script('http://maps.google.com/maps/api/js?libraries=geometry&sensor=false');
        echo $this->Html->script('underscore-min');
        echo $this->Html->script('jquery-1.5.1.min');
        echo $this->Html->script('jquery-ui-1.8.14.custom.min');
        echo $this->Html->script('jquery.ui.datepicker-fi') ;
        echo $this->Html->script('ui.spinner.min');
        echo $this->Html->script('jquery.qtip.min');
        echo $this->Html->script('jquery.tmpl.min');
        echo $this->Html->script('knockout-1.2.1.debug');
        // echo $this->Html->script('knockout-1.2.1');
        echo $this->Html->script('knockout.mapping');
        // echo $this->Html->script('jquery.meow');
        // echo $this->Html->script('smoke');
        echo $this->Html->script('jquery.tokeninput');
        echo $this->Html->script('jscolor/jscolor');
		echo $this->Html->script('Gettext');

        echo $scripts_for_layout;
    ?>
	
    <script>

$( document ).ready(function() {
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
	
</head>
<body>

    <div id="container">
	
		<div class="langbar">
			<?php
			/*
				echo $this->Html->link(
					'Suomi',
					array('language'=>'fin')
				);
			
			
				echo $this->Html->link(
					'Enganti',
					array('language'=>'eng')
				);
				*/
			?>
			
			<?php echo $this->Html->image("flags/fin.png", array(
				"alt" => "Finnish",
				'url' => array('controller' => 'polls', 'action' => 'index', 'language'=>'fin'),
				'class' => 'languageFlag'
			)); ?>
			
			<?php echo $this->Html->image("flags/eng.png", array(
				"alt" => "English",
				'url' => array('controller' => 'polls', 'action' => 'index', 'language'=>'eng'),
				'class' => 'languageFlag'
			)); ?>
			
		</div>
	
		
        <div id="header">
            <h1>Soft-GIS</h1>
        </div>
		
		<?php
			//  Ilmoitus käsittelemättömien tukipyyntöjen määrästä
			if(isset($userNotification))
			{
				echo ($userNotification);
			}
		?>

        <?php echo $this->Session->flash(); ?>
        <div id="navbar">
            <?php echo $this->Html->link(
                __('Omat kyselyt', true),
                array('controller' => 'polls', 'action' => 'index'),
                array('class' => 'button')
            );?>
            <?php echo $this->Html->link(
                __('Luo uusi kysely', true),
                array('controller' => 'polls', 'action' => 'modify'),
                array('class' => 'button')
            );?>
            <?php echo $this->Html->link(
                __('Karttamerkit', true),
                array('controller' => 'markers', 'action' => 'index'),
                array('class' => 'button')
            );?>
            <?php echo $this->Html->link(
                __('Vektoriaineistot', true),
                array('controller' => 'paths', 'action' => 'index'),
                array('class' => 'button')
            );?>
            <?php echo $this->Html->link(
                __('Karttakuvat', true),
                array('controller' => 'overlays', 'action' => 'index'),
                array('class' => 'button')
            );?>
			<?php
				if(isset($accessToUserControl))
				{
					if($accessToUserControl==1)
					{
						echo $this->Html->link(
							__('Käyttäjähallinta', true),
							array('controller' => 'authors', 'action' => 'view'),
							array('class' => 'button cancel')
						);
					}
				}
			?>
			<?php echo $this->Html->link(
				__('Profiili', true),
				array('controller' => 'authors', 'action' => 'profile'),
				array('class' => 'button cancel')
			);?>
            <?php echo $this->Html->link(
                __('Kirjaudu ulos', true),
                array('controller' => 'authors', 'action' => 'logout'),
                array('class' => 'button cancel')
            );?>
        </div>		
		
        <div id="content">


            <?php echo $content_for_layout; ?>

        </div>
    </div>
    <?php #echo $this->element('sql_dump'); ?>
</body>
</html>