<?php

class Request extends AppModel
{
	var $name = 'Request';
	
	public $hasMany = array(
        'Author' => array(
            'foreign_key' => 'author_id',
			'dependent'    => true
        )
    );
	
	function __construct()
	{
		parent::__construct();

		$this->validate = array(
            'minLength' => array(
                'rule' => array('minLength', 10),
                'message' => __('Pyynnön täytyy olla tarpeeksi selkä. Käytä vähintään 10 merkkiä.', true)
            )
		);
	}
}
