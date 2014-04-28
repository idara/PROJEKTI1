



<div class="answerMenu">
    <a href="#help" class="button" id="toggleHelp"><?php __('Ohje'); ?></a>
</div>


<h2><?php __('Tuo aineisto'); ?></h2>

<div class="help">
    <h2><?php __('Aineiston tuominen'); ?></h2>
    <p><?php __('Voit tuoda aineiston <b>shapefile</b> -tiedostosta. Ohjelma muuntaa sen automaattisesti Google Mapsin ymmärtämään muotoon.'); ?></p>
    <p></p>
</div>


<form method="post" enctype="multipart/form-data" >
   <input type="file" name="file[]" multiple id="file"/>
   <br><br>
   <button type="submit" name="clicked" class="button">Jatka</button>
</form>
