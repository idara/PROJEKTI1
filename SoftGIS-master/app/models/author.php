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

    function __construct()
	{
		parent::__construct();

		$this->validate = array(
			'username' => array(
				'isUnique' => array(
					'rule' => 'isUnique',
					'message' => __('Käyttäjätunnus on jo käytössä.', true)
				),
				'minLength' => array(
					'rule' => array('minLength', 3),
					'message' => __('Käyttäjätunnuksen täytyy olla vähintään 3 merkkiä pitkä.', true)
				),
				'maxLength' => array(
					'rule' => array('maxLength', 50),
					'message' => __('Käyttäjätunnus ei saa olla yli 50 merkkiä pitkä.', true)
				)
			),
			'email' => array(
				'isUnique' => array(
					'rule' => 'isUnique',
					'message' => __('Sähköpostiosoite on jo käytössä.', true)
				),
				'isEmail' => array(
					'rule' => 'email',
					'message' => __('Sähköpostiosoitteen on oltava muotoa erkki@esimerkki.fi', true)
				)
			),
		);
	}
}
