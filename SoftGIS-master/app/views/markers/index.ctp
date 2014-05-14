<h2><?php __('Karttamerkit'); ?></h2>
<div class="subnav">
    <?php echo $this->Html->link(
        __('Luo uusi karttamerkki', true),
        array('action' => 'edit'),
        array('class' => 'button')
    ); ?>
</div>

<h3><?php __('Käyttäjän karttamerkit'); ?></h3>
<table class="list">
    <thead>
        <tr>
            <th><?php __('Nimi'); ?></th>
            <th><?php __('Muokkaa'); ?></th>
            <th><?php __('Muokattu'); ?></th>
            <th><?php __('Kopioi'); ?></th>
            <th><?php __('Poista'); ?></th>
            <th><?php __('Käytössä'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($markers as $marker): ?>
            <tr>
                <td>
                    <?php echo $this->Html->link(
                        $marker['Marker']['name'], 
                        array('action' => 'view', $marker['Marker']['id']),
                        array('title' => __('Katsele karttamerkkiä', true))
                        );
                    ?>
                </td>
                <td>
                    <?php echo $this->Html->link(
                        __('muokkaa', true), 
                        array('action' => 'edit', $marker['Marker']['id']),
                        array('title' => __('Muokkaa karttamerkkiä', true))
                        );
                    ?>
                </td>
                <td>
                    <?php echo $marker['Marker']['modified']; ?>
                </td>
                <td>
                    <?php echo $this->Html->link(
                        __('kopioi', true), 
                        array('action' => 'copy', $marker['Marker']['id']),
                        array('title' => 'Kopioi karttamerkki'),
                        __('Oletko varma että haluat kopioida karttamerkin?', true)
                        );
                    ?>
                </td>
                <td>
                    <?php echo $this->Html->link(
                        __('poista', true), 
                        array('action' => 'delete', $marker['Marker']['id']),
                        array('title' => 'Poista karttamerkki'),
                        __('Oletko varma että haluat poistaa karttamerkin?', true)
                        );
                    ?>
                </td>
                <td>
                    <?php echo count($marker['Poll']); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- <h3>Muiden karttamerkit</h3> //Muiden käyttäjien tiedot poistettu käytöstä mahdollisten aineistojen lisenssiongelmien vuoksi
<table class="list">
    <thead>
        <tr>
            <th>Nimi</th>
            <th>Kopioi</th>
        </tr>
    </thead>
    <tbody>
        <?php #foreach ($others_markers as $marker): ?>
            <tr>
                <td>
                    <?php echo $this->Html->link(
                        $marker['Marker']['name'], 
                        array('action' => 'view', $marker['Marker']['id']),
                        array('title' => __('Katsele aineistoa', true))
                        );
                    ?>
                </td>
                <td>
                    <?php echo $this->Html->link(
                        __('kopioi', true), 
                        array('action' => 'copy', $marker['Marker']['id']),
                        array('title' => 'Kopioi aineisto'),
                        __('Oletko varma että haluat kopioida aineiston?', true)
                        );
                    ?>
                </td>
            </tr>
        <?php #endforeach; ?>
    </tbody>
</table> -->

