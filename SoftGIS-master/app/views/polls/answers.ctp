<script type="text/javascript">

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


	var pollNam = "<?php echo($pollNam); ?>";
	
	function createCSV()
	{
		var responses = <?php echo json_encode($answers); ?>;
		var head = <?php echo json_encode($header); ?>;
		var text = "";

		//header
		text = text + head.date;
		for (var x = 0; x < head.answer.length; x++) {
			text = text + ',"Kys:' + head.answer[x].num + ' teksti:' + head.answer[x].text.replace(/"/g,'""') + '","Kys:' + head.answer[x].num + ' kartta:' + head.answer[x].map + '"';
		}
		text = text + "\n";

		//answers
		for (var i = 0; i < responses.length; i++) {
			text = text + responses[i].date;
			for (var x = 0; x < responses[i].answer.length; x++) {
				var map = responses[i].answer[x].map; //if the old database does not contain a value at map.
				if (map) {
					map = google.maps.geometry.encoding.decodePath(map).toString();
				} else {
					map = "";
				}
				text = text + ',"' + responses[i].answer[x].text.replace(/"/g,'""') + '","' + map + '"';
			}
			text = text + "\n";
		}
		
		return text;
		
	} // / createCSV
	
	// createMIF()
	function createMIF()
	{
		// http://resource.mapinfo.com/static/files/document/1074660800077/interchange_file.pdf

		var responses = <?php echo json_encode($answers); ?>;
		var head = <?php echo json_encode($header); ?>;
		var text = "";
		var mid_text = "";
		var csvNoMap_text = "QUESTIONNUM integer, QUESTION char (65535), MAPANSWERTYPE char (65535), TEXTANSWERTYPE char (65535), TEXTANSWER char (65535)\n";		
		var mid_text_tmp = "";
		var mapanswertype = '';
		var textanswertype = '';

		//header
		text = text + "VERSION 300\nCHARSET \"UTF-8\" \nDELIMITER \",\" \nCoordSys Earth Projection 1\, 104\n";
		text = text + "\nCOLUMNS 5 \nQUESTIONNUM char (65535) \nQUESTION char (65535) \nMAPANSWERTYPE char (65535) \nTEXTANSWERTYPE char (65535) \nTEXTANSWER char (65535) \n";
		text = text + "\nDATA";

		//answers
		for (var i = 0; i < responses.length; i++) {
			//text = text + responses[i].date;
			for (var x = 0; x < responses[i].answer.length; x++) {
				var map = responses[i].answer[x].map; //if the old database does not contain a value at map.
				if (map) {
					map = google.maps.geometry.encoding.decodePath(map).toString();
				} else {
					map = "";
				}
				var mapLength = map.length;
				
				// Käännetään koordinaattipari oikein päin WGS84:lle
				map = map.split("),(");
				var tuloste = "";
				var mapPrintable = "";
				for (var k = 0; k < map.length; k++)
				{
					//Turhat merkit pois
					map[k] = map[k].replace(/\(/g,"").replace(/\)/g,"");
					map[k] = map[k].split(", ");
					tmp0 = map[k][0];
					tmp1 = map[k][1];
					map[k] = tmp1 + " " + tmp0;
					
					mapPrintable = mapPrintable + map[k] + "\n";
				}
				
				/*
				Karttavastauksen tyyppi:
				0 = Ei karttaa
				1 = Kartta, ei vastausta
				2 = Kartta, 1 merkki
				3 = Kartta, monta merkkiä
				4 = Kartta, viiva
				5 = Kartta, alue
				
				Tekstivastauksen tyyppi:
				0 = Ei tekstivastausta
				1 = Teksti
				2 = Kyllä, Ei, En osaa sanoa
				3 = 1 - 5, En osaa sanoa
				4 = 1 - 7, en osaa sanoa
				5 = Monivalinta (max 9)
				
				MID-Tiedosto
					COLUMNS 5
						QUESTIONNUM integer
						QUESTION char (65535)
						MAPANSWERTYPE integer
						TEXTANSWERTYPE integer
						TEXTANSWER char (65535)
				*/
				

				
				// Karttavastauksen tyypin muunto
				if(head.answer[x].map == 0)
				{
					mapanswertype = '<?php echo __('Ei karttaa', true); ?>';
				}
				else if(head.answer[x].map == 1)
				{
					mapanswertype = '<?php echo __('Kartta - ei vastausta', true); ?>';
				}
				else if(head.answer[x].map == 2)
				{
					mapanswertype = '<?php echo __('Kartta - 1 merkki', true); ?>';
				}
				else if(head.answer[x].map == 3)
				{
					mapanswertype = '<?php echo __('Kartta - monta merkkiä', true); ?>';
				}
				else if(head.answer[x].map == 4)
				{
					mapanswertype = '<?php echo __('Kartta - viiva', true); ?>';
				}
				else if(head.answer[x].map == 5)
				{
					mapanswertype = '<?php echo __('Kartta - alue', true); ?>';
				}
				
				// Tekstivastauksen tyypin muunto
				if(head.answer[x].text == 0)
				{
					textanswertype = '<?php echo __('Ei tekstivastausta', true); ?>';
				}
				else if(head.answer[x].text == 1)
				{
					textanswertype = '<?php echo __('Teksti', true); ?>';
				}
				else if(head.answer[x].text == 2)
				{
					textanswertype = '<?php echo __('Kyllä - Ei - En osaa sanoa', true); ?>';
				}
				else if(head.answer[x].text == 3)
				{
					textanswertype = '<?php echo __('1 - 5 - En osaa sanoa', true); ?>';
				}
				else if(head.answer[x].text == 4)
				{
					textanswertype = '<?php echo __('1 - 7 - En osaa sanoa', true); ?>';
				}
				else if(head.answer[x].text == 5)
				{
					textanswertype = '<?php echo __('Monivalinta (max 9)', true); ?>';
				}
				
				// Luodaan rivi MID-tiedostoa varten
				//mid_text = mid_text + head.answer[x].num + ',' + head.answer[x].questionText + ',' + mapanswertype + ',' + textanswertype + ',' + responses[i].answer[x].text.replace(/"/g,'""').replace(/,/g,';') + '\n';
				mid_text_tmp = head.answer[x].num + ',' + head.answer[x].questionText + ',' + mapanswertype + ',' + textanswertype + ',' + responses[i].answer[x].text.replace(/"/g,'""').replace(/,/g,';') + '\n';
				
				// Koordinaattien lukumäärä
				var pointCount = map.length;

				// Muotoillaan tiedostoon lisättävä rivi kyskymystyypin mukaan
				if(head.answer[x].map == 0) // Ei karttaa
				{
					//text = text + '\n' + '\nEi karttaa \n' + pointCount + '\n' + mapPrintable + '\n';
					csvNoMap_text = csvNoMap_text + mid_text_tmp
				}
				else if(head.answer[x].map == 1) // Kartta, ei vastausta
				{
					//text = text + '\nKartta - ei vastausta \n' + pointCount + '\n' + mapPrintable + '\n';
					csvNoMap_text = csvNoMap_text + mid_text_tmp
				}
				else if(mapLength == 0) // Ei karttavastausta ( Käyttäjä ei halunnut vastata kartalle)
				{
					//text = text + '\n' + '\nEi karttavastausta \n' + pointCount + '\n' + mapPrintable + '\n';
					csvNoMap_text = csvNoMap_text + mid_text_tmp
				}
				else if(head.answer[x].map == 2) // Kartta - 1 merkki
				{
					text = text + '\nPOINT ' + mapPrintable + 'SYMBOL \(67,16711680,10\)\n';
					mid_text = mid_text + mid_text_tmp
				}
				else if(head.answer[x].map == 3) // Kartta, monta merkkiä
				{
					text = text + '\nMULTIPOINT ' + pointCount + '\n' + mapPrintable + 'SYMBOL \(67,16711680,10\)\n';
					mid_text = mid_text + mid_text_tmp
				}
				else if(head.answer[x].map == 4) // Kartta, viiva
				{
					text = text + '\nPLINE \n' + pointCount + '\n' + mapPrintable + 'PEN (2,2,0)\n';
					mid_text = mid_text + mid_text_tmp
				}
				else if(head.answer[x].map == 5) // Kartta, alue
				{
					text = text + '\nREGION 1 \n' + pointCount + '\n' + mapPrintable + 'PEN (2,2,0)\nBRUSH (1,0,65280)\n';
					mid_text = mid_text + mid_text_tmp
				}
			}
		}
		
		var fileData = new Array(3);
		fileData['mif'] = text;
        fileData['mid'] = mid_text;
		fileData['csvNoMap'] = csvNoMap_text;
		
		return fileData;
		
	} //  / createMIF()

	
	var csvData = createCSV();
	var mifData = createMIF();
	
    function setContent() {
        //Update answer content according the arswers
		
		//CSV
		//document.getElementById("csv").innerHTML = csvData;
        document.getElementById("csv_lataus").href = "data:application/csv;charset=utf-8," + "sep=,%0A" + csvData.replace(/\n/g,'%0A').replace(/ /g,'%20');
        document.getElementById("csv_lataus").download = pollNam.replace(/ /g,"_") + '_vastaukset.csv';
			
		//========================================================
		
		//MIF
        //document.getElementById("mif").innerHTML = mifData['mif'];
        document.getElementById("mif_lataus").href = "data:application/mif;charset=utf-8," + mifData['mif'].replace(/\n/g,'%0D%0A').replace(/ /g,'%20');
        document.getElementById("mif_lataus").download = pollNam.replace(/ /g,"_") + '_vastaukset.mif';
		
		//MID
		//document.getElementById("mid").innerHTML = mifData['mid'];
        document.getElementById("mid_lataus").href = "data:application/mid;charset=utf-8," + mifData['mid'].replace(/\n/g,'%0D%0A').replace(/ /g,'%20');
        document.getElementById("mid_lataus").download = pollNam.replace(/ /g,"_") + '_vastaukset.mid';
		
		//csvNoMap
		document.getElementById("csvNoMap_lataus").href = "data:application/csv;charset=utf-8," + "sep=,%0A" + mifData['csvNoMap'].replace(/\n/g,'%0A').replace(/ /g,'%20');
        document.getElementById("csvNoMap_lataus").download = pollNam.replace(/ /g,"_") + '_vastaukset.csv';
    }
	
    window.addEventListener("load", setContent, false);
</script>

<h2><?php __('Vastaukset') ?></h2>

<div class="subnav">
    <?php echo $this->Html->link(
        __('Takaisin', true),
        array(
            'action' => 'view',
            $pollId
        ),
        array(
            'class' => 'button'
        )
    ); ?>
</div>

<div class="csv_area">
    <h4><?php __('Comma-separated values (CSV)'); ?></h4>

    <a class="button" id="csv_lataus" download="example.csv" href="data:application/csv;charset=utf-8,Col1%2CCol2%0AVal1%2CVal2" title="<?php __('Lataa CSV-tiedostona'); ?>"><?php __('CSV-tiedosto'); ?></a>
	
	<div class="help answersArea">
		<p><?php __('Vastaukset on esitetty CSV muodossa siten että jokaisen vastaajan vastaukset ovat yhdellä rivillä, pilkulla erotettuina.'); ?></p>
		<p><?php __('Ensimmäinen rivi on otsikko, jossa ensin on teksti \'aika\', sen jälkeen jokaista kysymystä kohden: kysymyksen numero tekstivastauksen tyyppi, kysymyksen numero karttavastauksen tyyppi. Vastausten tyyppien selitteet ohjeen lopussa.'); ?></p>
		<p><?php __('Lopuilla riveilla rivin ensimmäinen arvo on vastausaika. Sen jälkeen arvot noudattavat seuraavaa sarjaa jokaista kysymystä kohden: tekstivastaus, (leveyspiiri, pituuspiiri), jossa leveys- ja pituuspiirisarjoja voi olla monta tai ei yhtään kapplaetta'); ?></p>
		<p><?php __('Voit ladata vastaukset csv -tiedostona ohjeen yläpuolella olevasta painikkeesta.'); ?> <?php __('Tiedostossa käytetään UTF-8 merkistökoodausta.'); ?></p>
		<p><?php __('Huomautus: Vastauksissa kyselyn kysymykset eivät välttämättä ole numerojärjestyksessä, koska tämä ongelma huomattiin vasta projektin myöhäisessä vaiheessa. Siirrettyäsi vastaukset taukukkolaskentaohjelmaan, jokaisessa sarakkeessa pitäisi kuitenkin olla sarakkeen otsikossa mainittuun kysymykseen annetut vastaukset.'); ?></p>
		
		<br>

		<p><b><?php __('Tekstivastauksen tyyppi'); ?></b></p>
			<p>0 = <?php __('Ei tekstivastausta'); ?></p>
			<p>1 = <?php __('Teksti'); ?></p>
			<p>2 = <?php __('Kyllä, Ei, En osaa sanoa'); ?></p>
			<p>3 = <?php __('1 - 5, En osaa sanoa'); ?></p>
			<p>4 = <?php __('1 - 7, En osaa sanoa'); ?></p>
			<p>5 = <?php __('Monivalinta (max 9)'); ?></p>
			
			<br>
			
		<p><b><?php __('Karttavastauksen tyyppi'); ?></b></p>
			<p>0 = <?php __('Ei karttaa'); ?></p>
			<p>1 = <?php __('Kartta, ei vastausta'); ?></p>
			<p>2 = <?php __('Kartta, 1 merkki'); ?></p>
			<p>3 = <?php __('Kartta, monta merkkiä'); ?></p>
			<p>4 = <?php __('Kartta, viiva'); ?></p>
			<p>5 = <?php __('Kartta, alue'); ?></p>
	</div>
	
</div>

<div class="mif_area">
    <h4><?php __('MapInfo Interchange Format'); ?></h4>
	
	<a class="button" id="mif_lataus" download="example.mif" href="data:application/mif;charset=utf-8,Col1%2CCol2%0AVal1%2CVal2" title="<?php __('Lataa MIF-tiedostona'); ?>"><?php __('MIF-tiedosto'); ?></a>
	
	<a class="button" id="mid_lataus" download="example.mid" href="data:application/mid;charset=utf-8,Col1%2CCol2%0AVal1%2CVal2" title="<?php __('Lataa MID-tiedostona'); ?>"><?php __('MID-tiedosto'); ?></a>
	
	<a class="button" id="csvNoMap_lataus" download="example.csv" href="data:application/csv;charset=utf-8,Col1%2CCol2%0AVal1%2CVal2" title="<?php __('Lataa kartattomat vastaukset CSV-tiedostona'); ?>"><?php __('CSV-tiedosto'); ?></a>

	
	<div class="help answersArea">
		<p><?php __('Vastaukset on esitetty MapInfo Interchange Format muodossa siten, että mif-tiedosto sisältää varsinaisen paikkatiedon ja mid-tiedosto paikkatietoihin liittyvän tekstimuotoisen datan.'); ?></p>
		<p><?php __('CSV-tiedosto sisältää vastaukset, joihin ei liity paikkatietodataa.'); ?></p>
		<p><?php __('Kaikkissa tiedostoissa on merkistökoodauksena UTF-8.'); ?></p>
		<p><?php __('Vastaukset ovat vastauskertojen mukaisessa järjestyksessä.'); ?></p>
		<p><?php __('Voit ladata vastaukset mif ja mid -tiedostoina ohjeen yläpuolella olevista painikkeista.'); ?></p>
		
		<br><br>
		
		<p><b><?php __('MIF -tiedoston HEADER -osio'); ?></b></p>
		<table class="helpTable">
			<tr>
				<td>VERSION</td>
				<td>300</td>
			</tr>
			<tr>
				<td>DELIMITER</td>
				<td>,</td>
			</tr>
			<tr>
				<td>CoordSys</td>
				<td>Earth Projection 1, 104</td>
			</tr>
			<tr>
				<td>CHARSET</td>
				<td>utf-8</td>
			</tr>
		
		</table>		
		
		<br>
		
		<p><b><?php __('MID-tiedoston sarakkeet'); ?></b></p>
			<table class="helpTable">
				<tr>
					<td>QUESTIONNUM<br>integer</td>
					<td>=</td>
					<td><?php __('Kysymyksen numero'); ?></td>
				</tr>
				<tr>
					<td>QUESTION <br>char (65535)</td>
					<td>=</td>
					<td><?php __('Kysymys'); ?></td>
				</tr>
				<tr>
					<td>MAPANSWERTYPE <br>integer</td>
					<td>=</td>
					<td><?php __('Karttavastauksen tyyppi'); ?></td>
				</tr>
				<tr>
					<td>TEXTANSWERTYPE <br>integer</td>
					<td>=</td>
					<td><?php __('Tekstivastauksen tyyppi'); ?></td>
				</tr>
				<tr>
					<td>TEXTANSWER <br>char (65535)</td>
					<td>=</td>
					<td><?php __('Vastaus'); ?></td>
				</tr>
			</table>

		<br>
		
		<p><b><?php __('Tekstivastauksen tyyppi'); ?></b></p>
			<p>0 = <?php __('Ei tekstivastausta'); ?></p>
			<p>1 = <?php __('Teksti'); ?></p>
			<p>2 = <?php __('Kyllä, Ei, En osaa sanoa'); ?></p>
			<p>3 = <?php __('1 - 5, En osaa sanoa'); ?></p>
			<p>4 = <?php __('1 - 7, En osaa sanoa'); ?></p>
			<p>5 = <?php __('Monivalinta (max 9)'); ?></p>
			
			<br>
			
		<p><b><?php __('Karttavastauksen tyyppi'); ?></b></p>
			<p>0 = <?php __('Ei karttaa'); ?></p>
			<p>1 = <?php __('Kartta, ei vastausta'); ?></p>
			<p>2 = <?php __('Kartta, 1 merkki'); ?></p>
			<p>3 = <?php __('Kartta, monta merkkiä'); ?></p>
			<p>4 = <?php __('Kartta, viiva'); ?></p>
			<p>5 = <?php __('Kartta, alue'); ?></p>
	</div>
</div>