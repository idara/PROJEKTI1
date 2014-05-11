<script>


var map;

var decodedCoordinates = new google.maps.MVCArray();

function encodeCoordinates(){
    var encodedCoordinates = $('#PathCoordinates').val();
    //console.info(encodedCoordinates);
    encodedCoordinates = encodedCoordinates.split( " " );
    _.each(encodedCoordinates, function(i) {
        decodedCoordinates.push(google.maps.geometry.encoding.decodePath(i));
    });
    //console.info(decodedCoordinates);
}


$( document ).ready(function() {

    $("#PathStrokeOpacity").spinner({
        min: 0.0,
        max: 1.0,
        step: 0.05
    });

    $("#PathFillOpacity").spinner({
        min: 0.0,
        max: 1.0,
        step: 0.05
    });

    $("#PathStrokeWeight").spinner({
        min: 0.0,
        max: 10.0,
        step: 0.5
    });

    //alustetaan markkerit kartalle
    encodeCoordinates()

    //get the route's position from array
    var pos;
    var zoom;
    if (decodedCoordinates.getLength() > 0) {
        pos = decodedCoordinates.getAt(0)[0];
        zoom = 12;
    }

    //in case we don't get a position from the array
    if (typeof pos == 'undefined'){
        pos = new google.maps.LatLng("64.94216", "26.235352");
        zoom = 6;
    }

    map = new google.maps.Map( 
        $( "#map" ).get()[0],
        {
            zoom: zoom,
            center: pos,
            clickable: false,
            streetViewControl: false,
            disableDoubleClickZoom: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
    );

    var elements = [];
    decodedCoordinates.forEach(function(path) {
        var el;
        if ($('#PathType').val() == 1) {
            el = new google.maps.Polyline({
                map: map,
                strokeColor: "#" + $("#PathStrokeColor").val(),
                strokeOpacity: $("#PathStrokeOpacity").val(),
                strokeWeight: $("#PathStrokeWeight").val(),
                path: path
            });
        } else {
            el = new google.maps.Polygon({
                map: map,
                strokeColor: "#" + $("#PathStrokeColor").val(),
                strokeOpacity: $("#PathStrokeOpacity").val(),
                strokeWeight: $("#PathStrokeWeight").val(),
                fillColor: "#" + $("#PathFillColor").val(),
                fillOpacity: $("#PathFillOpacity").val(),
                path: path
            });
        }
        elements.push(el);

    });
    //console.info(elements);

    $("#otsikko").html("<h3>" + $("#PathName").val() + "</h3>");
    $("#sisältö").html($("#PathContent").val());
    
});
</script>


<h1><?php __('Aineiston tiedot'); ?></h1>
    <div class="subnav">
        <?php 
            if ($this->data['Path']['author_id'] == $author) {
                echo $this->Html->link(
                    __('muokkaa', true), 
                    array('action' => 'edit', $this->data['Path']['id']),
                    array('class' => 'button','title' => __('Muokkaa aineistoa', true))
                );
            }

            echo $this->Html->link(
                __('kopioi', true), 
                array('action' => 'copy', $this->data['Path']['id']),
                array('class' => 'button','title' => __('Kopioi aineisto', true)),
                __('Oletko varma että haluat kopioida aineiston?', true)
            );
            
            if ($this->data['Path']['author_id'] == $author) {
                echo $this->Html->link(
                    __('poista', true), 
                    array('action' => 'delete', $this->data['Path']['id']),
                    array('class' => 'button','title' => __('Poista aineisto', true)),
                    __('Oletko varma että haluat poistaa aineiston?', true)
                );
            }
        ?>
    </div>
<div id="otsikko"></div>
<div id="sisältö"></div>

<?php echo $this->Form->create('Path'); ?>
<div hidden>
    <?php echo $this->Form->input(
        'name', 
        array('label' => __('Nimi', true))
    ); ?>
    <?php echo $this->Form->input(
        'content', 
        array('label' => __('Sisältö', true))
    ); ?>
    <?php echo $this->Form->input(
        'type', 
        array('label' => __('Aineiston tyyppi', true), 'options' => array('none',__('Viiva', true), __('Alue', true)))
    ); ?>
    <?php echo $this->Form->input(
        'stroke_color', 
        array('label' => __('Viivan väri', true), 'class' => 'color small')
    ); ?>
    <?php echo $this->Form->input(
        'stroke_opacity', 
        array('label' => __('Viivan opasitetti', true), 'class' => 'small')
    ); ?>
    <?php echo $this->Form->input(
        'stroke_weight', 
        array('label' => __('Viivan paksuus', true), 'class' => 'small')
    ); ?>
    <?php echo $this->Form->input(
        'fill_color', 
        array('label' => 'Täytön väri', 'class' => 'color small')
    );?>
    <?php echo $this->Form->input(
        'fill_opacity', 
        array('label' => __('Täytön opasitetti', true), 'class' => 'small')
    ); ?>

    <?php echo $this->Form->input(
        'coordinates', 
        array('label' => __('Koordinaatit', true))
    ); ?>
</div>
<div class="input map-container">
    <!--<label>Esikatselu</label>-->
    <div id="map" class="map">
    </div>
</div>

<?php echo $this->Html->link(
    __('Takaisin', true),
    array('action' => 'index'),
    array('class' => 'button cancel')
); ?>
<?php echo $this->Form->end(); 
//debug($this->data);
?>


