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

<h2><?php __('Varmenteet'); ?></h2>
<h3><?php __('Luo uusia varmenteita, kpl.'); ?></h3>
<form method="POST" 
    action="<?php echo $this->Html->url(
            array('action' => 'generatehashes', $pollId)
        ); ?>">
    <input type="text" value="2" name="data[count]"/>
    <button type="submit"><?php __('Luo'); ?></button>
</form>

<hr />

<h3><?php __('Varmenteet'); ?></h3>
<table class="list small">
    <thead>
        <tr>
            <th><?php __('Varmenne'); ?></th>
            <th><?php __('Vastausosoite varmenteen kanssa'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($hashes as $hash): ?>
            <tr class="<?php echo $hash['Hash']['used'] ? 'red' : 'green'; ?>">
                <td><?php echo $hash['Hash']['hash']; ?></td>
                <td>
                    <?php echo FULL_BASE_URL . $this->Html->url(
                        array(
                            'controller' => 'answers',
                            'action' => 'index',
                            $hash['Hash']['poll_id'],
                            $hash['Hash']['hash']
                        )
                    ); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="help">
    <p><?php __('Vihrellä merkatut varmenteet ovat käyttämättömiä ja punaisella merkatut käytettyjä.'); ?></p>
    <p><?php __('Jokainen varmenne voidaan käyttää vain kerran. Varmenne muutetaan käytetyksi vasta kun vastausprosessi saadaan päätökseen ja vastaukset tallennetaan tietokantaan.'); ?></p>
</div>
