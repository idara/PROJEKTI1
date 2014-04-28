<h2>Karttakuvat</h2>
<div class="subnav">
    <?php echo $this->Html->link(
        __('Luo uusi karttakuva', true),
        array('action' => 'upload'),
        array('class' => 'button')
    ); ?>
</div>

<h3><?php __('Käyttäjän karttakuvat '); ?></h3>
<table class="list">
    <thead>
        <tr>
            <th><?php __('Nimi'); ?></th>
            <th><?php __('Muokkaa'); ?></th>
            <th><?php __('Muokattu'); ?></th>
            <th><?php __('Kopioi'); ?></th>
            <th><?php __('Poista'); ?></th>
            <th><?php __('Käytössä'); ?></th>
            <th><?php __('Kuvatiedosto'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($overlays as $overlay): ?>
            <tr>
                <td>
                    <?php echo $this->Html->link(
                        $overlay['Overlay']['name'], 
                        array('action' => 'view', $overlay['Overlay']['id']),
                        array('title' => __('Katsele karttakuvaa', true))
                        );
                    ?>
                </td>
                <td>
                    <?php echo $this->Html->link(
                        __('muokkaa', true), 
                        array('action' => 'edit', $overlay['Overlay']['id']),
                        array('title' => __('Muokkaa karttakuvaa', true))
                        );
                    ?>
                </td>
                <td>
                    <?php echo $overlay['Overlay']['modified']; ?>
                </td>
                <td>
                    <?php echo $this->Html->link(
                        __('kopioi', true), 
                        array('action' => 'copy', $overlay['Overlay']['id']),
                        array('title' => __('Kopioi aineisto', true)),
                        __('Oletko varma että haluat kopioida karttakuvan?', true)
                        );
                    ?>
                </td>
                <td>
                    <?php echo $this->Html->link(
                        __('poista', true),
                        array('action' => 'delete', $overlay['Overlay']['id']),
                        array('title' => __('Poista aineisto', true)),
                        __('Oletko varma että haluat poistaa karttakuvan?', true)
                        );
                    ?>
                </td>
                <td>
                    <?php echo count($overlay['Poll']); ?>
                </td>
                <td>
                    <?php if (file_exists(APP.'webroot'.DS.'overlayimages'.DS.$overlay['Overlay']['image'])) {
                        echo __('Löytyy', true);
                    } else {
                        echo __('Hukassa', true);
                    } ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- <h3>Muiden karttakuvat</h3> //Muiden käyttäjien tiedot poistettu käytöstä mahdollisten aineistojen lisenssiongelmien vuoksi
<table class="list">
    <thead>
        <tr>
            <th>Nimi</th>
            <th>Kopioi</th>
        </tr>
    </thead>
    <tbody>
        <?php #foreach ($others_overlays as $overlay): ?>
            <tr>
                <td>
                    <?php echo $this->Html->link(
                        $overlay['Overlay']['name'], 
                        array('action' => 'view', $overlay['Overlay']['id']),
                        array('title' => __('Katsele karttakuvaa', true))
                        );
                    ?>
                </td>
                <td>
                    <?php echo $this->Html->link(
                        __('kopioi', true), 
                        array('action' => 'copy', $overlay['Overlay']['id']),
                        array('title' => __('Kopioi aineisto', true)),
                        __('Oletko varma että haluat kopioida karttakuvan?', true)
                        );
                    ?>
                </td>
            </tr>
        <?php #endforeach; ?>
    </tbody>
</table> -->

