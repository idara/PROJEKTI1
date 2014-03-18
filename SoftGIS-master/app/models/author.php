<?php

class Author extends AppModel
{
	var $name = 'Author';
	
	var $belongsTo = array('Group');

    public $hasMany = array(
        'Poll' => array(
            'foreign_key' => 'author_id',
			'dependent'    => true
        )
    );

    public $validate = array(
        'username' => array(
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'Käyttäjänimi on varattu.'
            ),
            'minLength' => array(
                'rule' => array('minLength', 3),
                'message' => 'Käyttäjänimen täytyy olla vähintään 3 merkkiä pitkä.'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 50),
                'message' => 'Käyttäjänimi ei saa olla yli 50 merkkiä pitkä.'
            )
        )
    );
}
