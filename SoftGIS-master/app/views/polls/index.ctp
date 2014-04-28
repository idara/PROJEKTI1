<script>

var confirmPublish = "<?php __('Haluatko varmasti julkaista kyselyn? Julkaisun jälkeen kyselyä ei voida enää muokata'); ?>";

$( document ).ready(function() {
    $( "a.publish" ).click(function() {
        return confirm( confirmPublish );
    });
});

</script>

<h2><?php __('Omat kyselyt'); ?></h2>
<table class="list">
    <thead>
        <tr>
            <th><?php __('Nimi'); ?></th>
            <th><?php __('Testaa'); ?></th>
            <th><?php __('Julkinen'); ?></th>
            <th><?php __('Muokkaa'); ?></th>
            <th><?php __('Poista'); ?></th>
            <th><?php __('Kopioi'); ?></th>
            <th><?php __('Vastauksia'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($polls as $poll): ?>
            <tr>
                <td>
                    <?php echo $this->Html->link(
                        $poll['Poll']['name'],
                        array(
                            'controller' => 'polls', 
                            'action' => 'view',
                            $poll['Poll']['id']
                        ),
                        array(
                            'title' => __('Tarkastele kyselyä', true)
                        )
                    ); ?>
                </td>
                <td>
                    <?php echo $this->Html->link(
                        __('Testaa', true),
                        array(
                            'controller' => 'answers', 
                            'action' => 'test',
                            $poll['Poll']['id']
                        ),
                        array(
                            'title' => __('Testikäytä kyselyä', true)
                        )
                    ); ?>
                </td>
                <td>
                    <?php if ($poll['Poll']['public']) {
                        echo __('Kyllä', true);
                    } else {
                        echo (__('Ei', true) . ', ');
                        echo $this->Html->link(
                            __('hashit', true),
                            array('action' => 'hashes', $poll['Poll']['id'])
                        ); 
                    } ?>
				</td>
                <td>
                    <?php echo $this->Html->link(
                        __('Muokkaa', true),
                        array(
                            'action' => 'modify',
                            $poll['Poll']['id']
                        ),
                        array(
                            'title' => __('Muokkaa kyselyä', true)
                        )
                    ); ?>
                </td>
				<td>
                    <?php echo $this->Html->link(
                        __('Poista', true),
                        array(
                            'action' => 'delete',
                            $poll['Poll']['id'],
                        ),
                        array(
                            'title' => __('Poista kysely', true)
                        ),
						__('Oletko varma että haluat poistaa kyselyn?', true)
                    ); ?>
                </td>
                <td>
                    <?php echo $this->Html->link(
                        __('Kopioi', true),
                        array(
                            'action' => 'copy',
                            $poll['Poll']['id']
                        ),
                        array(
                            'title' => __('Kopioi uudeksi kyselyksi', true)
                        ),
                        __('Oletko varma että haluat kopioida kyselyn?', true)
                    ); ?>
                </td>
                <td><?php echo count($poll['Response']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>