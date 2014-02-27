<?php

class Group extends AppModel
{
	var $name = 'Group';
	
	var $hasMany = array(
		'Author' => array(
			'className' => 'Author',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	public $validate = array(
        'groupname' => array(
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'Ryhmän nimi on varattu.'
            ),
            'minLength' => array(
                'rule' => array('minLength', 3),
                'message' => 'Ryhmän nimen täytyy olla vähintään 3 merkkiä pitkä.'
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 50),
                'message' => 'Ryhmän nimi ei saa olla yli 50 merkkiä pitkä.'
            )
        )
    );
}
