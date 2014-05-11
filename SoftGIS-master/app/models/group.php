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
	
	
	function __construct()
	{
		parent::__construct();

		$this->validate = array(
			'groupname' => array(
				'isUnique' => array(
					'rule' => 'isUnique',
					'message' => __('Ryhmän nimi on jo käytössä.', true)
				),
				'minLength' => array(
					'rule' => array('minLength', 3),
					'message' => __('Ryhmän nimen täytyy olla vähintään 3 merkkiä pitkä.', true)
				),
				'maxLength' => array(
					'rule' => array('maxLength', 50),
					'message' => __('Ryhmän nimi ei saa olla yli 50 merkkiä pitkä.', true)
				)
			)
		);
	}
}
