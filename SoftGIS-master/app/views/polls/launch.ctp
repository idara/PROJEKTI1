<script>

$(document).ready(function() {
    $("#PollLaunch").datepicker();
    $("#PollEnd").datepicker();
});

</script>

<div class="subnav">
    <?php echo $this->Html->link(
        __('Takaisin', true),
        array(
            'action' => 'view',
            $poll['Poll']['id']
        ),
        array(
            'class' => 'button'
        )
    ); ?>
</div>

<?php echo $this->Form->create('Poll'); ?>

<div class="input text">
    <label><?php __('Alkamispäivä'); ?></label>
    <?php echo $this->Form->text(
        'launch',
        array(
            'type' => 'text', 
            'class' => 'small',
        )
    ); ?>
</div>

<div class="input text">
    <label><?php __('Päättymispäivä'); ?></label>
    <?php echo $this->Form->text(
        'end',
        array(
            'type' => 'text', 
            'class' => 'small',
        )
    ); ?>
</div>

<button type="submit" id="saveButton">
    <?php __('Tallenna muutokset'); ?>
</button>
<?php echo $this->Html->link(
    __('Peruuta', true),
    array(
        'action' => 'view',
        $poll['Poll']['id']
    ),
    array(
        'class' => 'button cancel'
    )
); ?>
<?php echo $this->Form->end(); ?>

<div class="help">
    <p><?php __('Kyselyn aukioloaikana käyttäjät voivat vastata kyselyyn. Alkamis- ja päättymispäivä sisältyvät aukioloaikaan.'); ?></p>
    <p><?php __('Kysely on suljettu, jos alkamispäivämäärää ei ole asetettu.'); ?></p>
</div>