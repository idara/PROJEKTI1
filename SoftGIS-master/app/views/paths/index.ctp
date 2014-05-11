<h2><?php __('Viivat ja alueet'); ?></h2>
<div class="subnav">
    <?php echo $this->Html->link(
        __('Luo uusi aineisto', true),
        array('action' => 'edit'),
        array('class' => 'button')
    );
	echo (" ");
    echo $this->Html->link(
        __('Tuo aineisto MIF-tiedostosta', true),
        array('action' => 'import'),
        array('class' => 'button')
    );
	/*
    echo $this->Html->link(
        __('Tuo aineisto Shapefile-tiedostosta', true),
        array('action' => 'import_shapefile'),
        array('class' => 'button')
    ); */
	?>
</div>

<h3><?php __('Käyttäjän aineistot'); ?></h3>
<table class="list"><!--Käyttäjän omat aineistot-->
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
        <?php foreach ($paths as $path): ?>
            <tr>
                <td>
                    <?php echo $this->Html->link(
                        $path['Path']['name'], 
                        array('action' => 'view', $path['Path']['id']),
                        array('title' => __('Katsele aineistoa', true))
                        );
                    ?>
                </td>
                <td>
                    <?php echo $this->Html->link(
                        __('muokkaa', true), 
                        array('action' => 'edit', $path['Path']['id']),
                        array('title' => __('Muokkaa aineistoa', true))
                        );
                    ?>
                </td>
                <td>
                    <?php echo $path['Path']['modified']; ?>
                </td>
                <td>
                    <?php echo $this->Html->link(
                        __('kopioi', true), 
                        array('action' => 'copy', $path['Path']['id']),
                        array('title' => __('Kopioi aineisto', true)),
                        __('Oletko varma että haluat kopioida aineiston?', true)
                        );
                    ?>
                </td>
                <td>
                    <?php echo $this->Html->link(
                        __('poista', true), 
                        array('action' => 'delete', $path['Path']['id']),
                        array('title' => __('Poista aineisto', true)),
                        __('Oletko varma että haluat poistaa aineiston?', true)
                        );
                    ?>
                </td>
                <td>
                    <?php echo count($path['Poll']); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- <h3>Muiden aineistot</h3> //Muiden käyttäjien tiedot poistettu käytöstä mahdollisten aineistojen lisenssiongelmien vuoksi
<table class="list">
    <thead>
        <tr>
            <th>Nimi</th>
            <th>Kopioi</th>
        </tr>
    </thead>
    <tbody>
        <?php #foreach ($others_paths as $path): ?>
            <tr>
                <td>
                    <?php echo $this->Html->link(
                        $path['Path']['name'], 
                        array('action' => 'view', $path['Path']['id']),
                        array('title' => __('Katsele aineistoa', true))
                        );
                    ?>
                </td>
                <td>
                    <?php echo $this->Html->link(
                        'kopioi', 
                        array('action' => 'copy', $path['Path']['id']),
                        array('title' => __('Kopioi aineisto'), true),
                        __('Oletko varma että haluat kopioida aineiston?', true)
                        );
                    ?>
                </td>
            </tr>
        <?php #endforeach; ?>
    </tbody>
</table> -->

