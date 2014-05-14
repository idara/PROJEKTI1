<script>

var markerIconPath = "<?php echo $this->Html->url('/markericons/'); ?>";

var map, marker = null;

$( document ).ready(function() {

    // Help toggle
    $( ".help" ).hide();
    $( "#toggleHelp" ).click(function() {
        $( ".help" ).fadeToggle(400, "swing");
        return false;
    });


    var initialPos, coords = null;
    if ($("#MarkerLatlng").val()) {
        coords = $("#MarkerLatlng").val().split(",", 2);
        initialPos = new google.maps.LatLng( coords[0], coords[1] );
    }

    map = new google.maps.Map(
        $( "#map" ).get()[0],
        {
            zoom: initialPos ? 8 : 5,
            center: initialPos ? initialPos : new google.maps.LatLng(64.94216, 26.235352),
            streetViewControl: false,
            disableDoubleClickZoom: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
    );

    google.maps.event.addListener(map, 'click', function(event) {
        addMarker(event.latLng);
    });

    if (initialPos) {
        addMarker(initialPos);
    }

    $( "#MarkerEditForm" ).submit(function() {
        if (marker) {
            var latLng = marker.getPosition();
            $( "#MarkerLatlng" ).val( latLng.lat() + "," + latLng.lng() );
            $( "#map" ).qtip( "destroy" );
        } else {
            $( "#map" ).qtip({
                content: "Aseta merkin sijainti kartalle",
                position: {
                    my: "bottom center",
                    at: "top center",
                    adjust: {
                        x: 200
                    }
                },
                show: {
                    ready: true,
                    event: null
                },
                hide: {
                    event: null
                },
                style: {
                    classes: "ui-tooltip-shadow ui-tooltip-rounded ui-tooltip-red"
                }
            });
            return false;
        }
    });

    $( "#MarkerIcon" ).change(function() {
        if (marker){
            var icon = $( this ).val();
            if ( icon == "default" ) {
                marker.setIcon( null );
            } else {
                marker.setIcon( markerIconPath + icon );
            }
        }
    });

});


function addMarker(location) {
    if(!marker){
        mar = new google.maps.Marker({
            position: location,
            map: map,
            draggable: true,
            icon: $("#MarkerIcon").val() != "default" ? (markerIconPath + $("#MarkerIcon").val()) : null
        });
        marker = mar;

        google.maps.event.addListener(marker, 'rightclick', function() {
            if (marker){
                marker.setMap(null);
                marker = null;
            }
        });
        $( "#map" ).qtip( "destroy" );
    }
}

</script>

<div class="answerMenu">
    <a href="#help" class="button" id="toggleHelp"><?php __('Ohje'); ?></a>
</div>

<h2><?php __('Karttamerkki'); ?></h2>

<div class="help">
    <h2><?php __('Karttamerkin asettaminen kartalle'); ?></h2>
    <p><?php __('Klikkaamalla karttaa voit asettaa merkin kartalle. Klikkaamalla merkkiä hiiren oikealla painikkeella voit poistaa sen kartalta.'); ?></p>
</div>

<?php echo $this->Form->create('Marker'); ?>
<?php echo $this->Form->input('name', array('label' => __('Nimi'),'placeholder'=> 'Anna nimi','required'=> true)); ?>
<?php echo $this->Form->input('content', array('label' => __('Sisältö', true))); ?>
<?php echo $this->Form->input('icon', array('label' => __('Kuvake', true))); ?>
<?php echo $this->Form->input('latlng', array('type' => 'hidden')); ?>
<div class="input map-container">
    <label><?php __('Sijainti'); ?></label>
    <div id="map" class="map">
    </div>
</div>
<button type="submit"><?php __('Tallenna'); ?></button>
<?php echo $this->Html->link(
    __('Peruuta', true),
    array('action' => 'index'),
    array('class' => 'button cancel')
); ?>
<?php echo $this->Form->end(); ?>
