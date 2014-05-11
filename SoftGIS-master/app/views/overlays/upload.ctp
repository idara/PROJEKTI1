<script>
$(document).ready(function() { // init when page has loaded

    // Help toggle
    //$( ".help" ).hide();
    $( "#toggleHelp" ).click(function() {
        $( ".help" ).fadeToggle(400, "swing");
        return false;
    });
});
</script>

<div class="answerMenu">
    <a href="#help" class="button" id="toggleHelp"><?php __('Ohje'); ?></a>
</div>

<h1><?php __('Karttakuvan lataaminen'); ?></h1>

<div class="help">
    <h2><?php __('Karttakuvan lataaminen'); ?></h2>
    <p><?php __('Voit tuoda kuvatiedoston omalta tietokoneeltasi painamalla "Selaa.." -nappia. '); ?></p>
    <p><?php __('Karttakuva voi olla .gif-, .jpeg-, .png- tai .jpg-tyyppinen ja enintään 1,5Mt kokoinen.'); ?></p>
    <h2><?php __('Karttakuvan luominen'); ?></h2>
    <p><?php __('SoftGIS-järjestelmän kartan käyttämä koordinaattijärjestelmä on WGS84.'); ?> <a href='http://en.wikipedia.org/wiki/Google_Maps#Map_projection'><?php __('Lisätietoa asiasta täältä (englanniksi).'); ?></a></p>
</div>
<div class="form">
    <?php echo $this->Form->create('Overlay', array('type' => 'file')); ?>
    <?php echo $this->Form->file('file', array('type' => 'file')); ?>

    <br>
    <?php echo $this->Form->button(__('Jatka', true), 
        array('type'=>'submit')); ?>
    <?php echo $this->Html->link(__('Takaisin', true), 
        array('action' => 'index'), array('class' => 'button cancel')); ?>

    <?php echo $this->Form->end(); ?>
</div>


