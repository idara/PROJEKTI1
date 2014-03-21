<?php
    echo $this->Session->flash('auth');
    echo $this->Form->create('Author');
    echo $this->Form->input(
        'username', 
        array('label' => __('Käyttäjänimi', true), 'autofocus' => 'autofocus')
    );
    echo $this->Form->input(
        'password',
        array('label' => __('Salasana', true))
    );
?>
<button type="submit"><?php __('Kirjaudu'); ?></button>
<?php echo $this->Form->end(); ?>
