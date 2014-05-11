<script>

var markerIconPath = "<?php echo $this->Html->url('/markericons/'); ?>";


$( document ).ready(function() {

    var initialPos, coords;
    if ($("#MarkerLatlng").val()) {
        coords = $("#MarkerLatlng").val().split(",", 2);
    } else {
        coords = ["64.94216", "26.235352"];
    }
    initialPos = new google.maps.LatLng( coords[0], coords[1] );

    var map = new google.maps.Map(
        $( "#map" ).get()[0],
        {
            zoom: 8,
            center: initialPos,
            clickable: false,
            streetViewControl: false,
            disableDoubleClickZoom: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
    );
    var marker = new google.maps.Marker({
        map: map,
        position: initialPos,
        icon: $("#MarkerIcon").val() != "default" ? (markerIconPath + $("#MarkerIcon").val()) : null
    });

    $("#otsikko").html("<h3>" + $("#MarkerName").val() + "</h3>");
    $("#sisältö").html($("#MarkerContent").val());
});

</script>

<h2><?php __('Karttamerkki'); ?></h2>

<?php 
    echo $this->Html->link(
        __('muokkaa', true), 
        array('action' => 'edit', $this->data['Marker']['id']),
        array('class' => 'button','title' => __('Muokkaa karttamerkkiä', true))
    );
    echo $this->Html->link(
        __('kopioi', true), 
        array('action' => 'copy', $this->data['Marker']['id']),
        array('class' => 'button','title' => __('Kopioi karttamerkki', true)),
        __('Oletko varma että haluat kopioida karttamerkin?', true)
    );
    echo $this->Html->link(
        __('poista', true), 
        array('action' => 'delete', $this->data['Marker']['id']),
        array('class' => 'button','title' => __('Poista karttamerkki', true)),
        __('Oletko varma että haluat poistaa karttamerkin?', true)
    );
?>

<div id="otsikko"></div>
<div id="sisältö"></div>

<div hidden>
    <?php echo $this->Form->create('Marker'); ?>
    <?php echo $this->Form->input('name', array('label' => __('Nimi', true),'placeholder'=>'Anna nimi','required'=> true)); ?>
    <?php echo $this->Form->input('content', array('label' => __('Sisältö', true))); ?>
    <?php echo $this->Form->input('icon', array('label' => __('Kuvake', true))); ?>
    <?php echo $this->Form->input('latlng', array('type' => 'hidden')); ?>
</div>
<div class="input map-container">
    <div id="map" class="map">
    </div>
</div>
<?php echo $this->Html->link(
    __('Takaisin', true),
    array('action' => 'index'),
    array('class' => 'button cancel')
); ?>
<?php echo $this->Form->end(); ?>