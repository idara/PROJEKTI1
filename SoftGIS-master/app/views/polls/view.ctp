<script>

$(document).ready(function() {
    $(".detailed > .details").hide();
    var current = null;
    $(".detailed > .header").click(function() {
        var thisDetails = $(this).next();

        thisDetails.slideToggle();
        if (current) {
            if (current.get(0) == thisDetails.get(0)) {
                current = null;
            } else {
                current.slideToggle();
                current = thisDetails;
            }
        } else {
            current = thisDetails;
        }
        return false;
    });
});


</script>

<h2><?php echo $poll['name']; ?></h2>

<div class="subnav">
    <?php
    echo $this->Html->link(
        __('Muokkaa', true),
        array(
            'action' => 'modify',
            $poll['id']
        ),
        array(
            'class' => 'button',
            'title' => __('Muokkaa kyselyä', true)
        )
    );
    echo $this->Html->link(
        __('Kokeile', true),
        array(
            'controller' => 'answers',
            'action' => 'test',
            $poll['id']
        ),
        array(
            'class' => 'button',
            'title' => __('Voit kokeilla kyselyyn vastaamista ennen sen julkaisua. Kokeiluvastauksia ei tallenneta.', true)
        )
    );
    echo $this->Html->link(
        __('Aseta aukioloaika', true),
        array(
            'action' => 'launch',
            $poll['id']
        ),
        array(
            'class' => 'button',
            'title' => __('Määrittele mistä mihin kysely on vastattavissa.', true)
        )
    );
    if ($poll['public'] == 0) {
        echo $this->Html->link(
            __('Varmenteet', true),
            array(
                'action' => 'hashes',
                $poll['id']
            ),
            array(
                'class' => 'button',
                'title' => __('Luo ja tarkastele varmenteita, joiden avulla kyselyyn vastaajat todennetaan.', true)
            )
        );
    };
    echo $this->Html->link(
        __('Vastaukset', true),
        array(
            'action' => 'answers',
            $poll['id']
        ),
        array(
            'class' => 'button',
            'title' => __('Tarkastele kyselyn vastauksia', true)
        )
    );
    echo $this->Html->link(
        __('Poista', true),
        array(
            'action' => 'delete',
            $poll['id'],
        ),
        array(
            'class' => 'button',
            'title' => __('Poista kysely', true)
        ),
        __('Oletko varma että haluat poistaa kyselyn?', true)
    );
    echo $this->Html->link(
        __('Kopioi', true),
        array(
            'action' => 'copy',
            $poll['id']
        ),
        array(
            'class' => 'button',
            'title' => __('Kopioi uudeksi kyselyksi', true)
        ),
        __('Oletko varma että haluat kopioida kyselyn?', true)
    );
    ?>
</div>

<h3><?php __('Yleistiedot'); ?></h3>
<table class="details">
    <tr>
        <th class="fixed"><?php __('Vastauksia'); ?></th>
        <td><?php echo $responseCount; ?></td>
    </tr>
    <tr>
        <th><?php __('Aukioloaika'); ?></th>
        <td>
            <?php
                $launch = $poll['launch'];
                if ($launch) {
                    echo date('j.n.Y', strtotime($launch)) . ' - ';
                    $end = $poll['end'];
                    if ($end) {
                        echo date('j.n.Y', strtotime($end));
                    } else {
                        echo __('Ei päättymispäivää', true);
                    }
                } else {
                    echo __('Ei aukioloaikaa', true);
                }
            ?>
        </td>
    </tr>
    <tr>
        <th><?php __('Kaikille avoin'); ?></th>
        <td><?php echo $poll['public'] ? __('Kyllä', true) : __('Ei', true); ?>
 
             <?php if ($poll['public'] == 1) {
                echo $this->Html->link(__('Muuta suljetuksi', true),
                    array('action' => 'openClosed',$poll['id']),
                    array('class' => 'button','title' => __('Muuta kysely suljetuksi', true)));
            } else {
                echo $this->Html->link(__('Muuta avoimeksi', true),
                    array('action' => 'openClosed',$poll['id']),
                    array('class' => 'button','title' => __('Muuta kysely avoimeksi', true)));
            } ?>
        </td>
    </tr>
    <tr>
        <th><?php __('Kuvaus'); ?></th>
        <td><?php echo $poll['welcome_text']; ?></td>
    </tr>
    <tr>
        <th><?php __('Kiitosteksti'); ?></th>
        <td><?php echo $poll['thanks_text']; ?></td>
    </tr>
	<tr>
        <th><?php __('Vastausosoite'); ?></th>
        <td>
            <?php if ($poll['public'] == 0) {
                echo $this->Html->link(
                    __('Katso varmenteet', true),
                    array(
                        'action' => 'hashes',
                        $poll['id']
                    )
                );
            }else{
                echo FULL_BASE_URL . $this->Html->url(
                    array(
                        'controller' => 'answers',
                        'action' => 'index',
                        $poll['id']
                    )
                );
            }; ?>
        </td>
    </tr>
</table>

<h3><?php __('Karttamerkit'); ?></h3>
<table class="details">
    <?php if (!empty($markers)): ?>
        <?php foreach ($markers as $marker): ?>
            <tr>
                <th class="mediumfixed"><?php echo $marker['name']; ?></th>
                <td><?php echo $marker['content']; ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td><?php __('Kyselyn yhteydessä ei ole näytettäviä karttamerkkejä'); ?></td></tr>
    <?php endif; ?>
</table>

<h3><?php __('Viivat ja alueet'); ?></h3>
<table class="details">
    <?php if (!empty($paths)): ?>
        <?php foreach ($paths as $path): ?>
            <tr>
                <th class="mediumfixed"><?php echo $path['name']; ?></th>
                <td><?php echo $path['content']; ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td><?php __('Kyselyn yhteydessä ei ole näytettäviä viivoja tai alueita'); ?></td></tr>
    <?php endif; ?>
</table>

<h3><?php __('Karttakuvat'); ?></h3>
<table class="details">
    <?php if (!empty($overlays)): ?>
        <?php foreach ($overlays as $overlay): ?>
            <tr>
                <th class="mediumfixed"><?php echo $overlay['name']; ?></th>
                <td><?php echo $overlay['content']; ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td><?php __('Kyselyn yhteydessä ei ole näytettäviä karttakuvia'); ?></td></tr>
    <?php endif; ?>
</table>

<h3><?php __('Kysymykset'); ?></h3>

<div>
<?php foreach ($questions as $q): ?>
    <div class="detailed">
        <div class="header">
            <span class="num"><?php echo $q['num']; ?></span>
            <span class="text"><?php echo $q['text']; ?></span>
        </div>
        <div class="details">
            <table class="details">
                <tr>
                    <th class="longfixed"><?php __('Tekstivastauksen tyyppi'); ?></th>
                    <td colspan="3"><?php echo $answers[$q['type']]; ?></td>
                </tr>
                <tr>
                    <th class="longfixed"><?php __('Karttavastauksen tyyppi'); ?></th>
                    <td colspan="3"><?php echo $map_answers[$q['map_type']]; ?></td>
                </tr>
                <tr>
                    <th><?php __('Sijainti'); ?></th>
                    <td> 
                        <?php echo empty($q['latlng']) ? __('Ei', true) : $q['latlng']; ?>
                    </td>
                </tr>
                <tr>
                    <th><?php __('Zoom-taso'); ?></th>
                    <td> 
                        <?php echo empty($q['zoom']) ? __('Ei', true) : $q['zoom']; ?>
                    </td>
                </tr>
                <!--<tr>
                    <th>Kohteen merkitseminen kartalle</th>
                    <td> 
                        <?php echo $q['answer_location'] ? __('Kyllä', true) : __('Ei', true); ?>
                    </td>
                </tr>-->
                <tr>
                    <th><?php __('Vastaukset näkyvissä muille vastaajille'); ?></th>
                    <td> 
                        <?php echo $q['answer_visible'] ? __('Kyllä', true) : __('Ei', true); ?>
                    </td>
                </tr>
                <!--<tr>
                    <th>Vastausten kommentointi</th>
                    <td colspan="3"> 
                        <?php echo $q['comments'] ? __('Kyllä', true) : __('Ei', true); ?>
                    </td>
                </tr>-->
            </table>
        </div>
    </div>
<?php endforeach; ?>
</div>

<?php
/*  <!-- Sama asia, kuin yllä, kommentoitu pois -->
<table class="details">
    <?php foreach ($questions as $q): ?>
        <tr>
            <td colspan="4" class="ul"><h4><?php echo $q['num']; ?></h4></td>
        </tr>
        <tr>
            <th class="fixed">Kysymys</th>
            <td colspan="3"><?php echo $q['text']; ?></td>
        </tr>
        <tr>
            <th>Vastaus</th>
            <td colspan="3"><?php echo $answers[$q['type']]; ?></td>
        </tr>
        <tr>
            <th>Sijainti</th>
            <td> 
                <?php echo empty($q['latlng']) ? 'Ei' : $q['latlng']; ?>
            </td>
            <th>Zoom-taso</th>
            <td> 
                <?php echo empty($q['zoom']) ? 'Ei' : $q['zoom']; ?>
            </td>
        </tr>
        <tr>
            <th>Kohteen merkitseminen kartalle</th>
            <td> 
                <?php echo $q['answer_location'] ? 'Kyllä' : 'Ei'; ?>
            </td>
            <th>Vastaukset näkyvissä muille vastaajille</th>
            <td> 
                <?php echo $q['answer_visible'] ? 'Kyllä' : 'Ei'; ?>
            </td>
        </tr>
        <tr>
            <th>Vastausten kommentointi</th>
            <td colspan="3"> 
                <?php echo $q['comments'] ? 'Kyllä' : 'Ei'; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
*/
?>