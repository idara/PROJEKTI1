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
                'message' => __('Pyynn�n t�ytyy olla tarpeeksi selke�. K�yt� v�hint��n 10 merkki�.', true)
            )
		);
	}
}
