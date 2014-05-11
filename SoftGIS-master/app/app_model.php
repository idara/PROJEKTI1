<?php

class AppModel extends Model
{
    public $actsAs = array(
        'Containable'
    );

	// http://ctrl-f5.net/php/cakephp-localized-form-validation/
	/*
	function invalidate($field, $value = true)
	{
	    return parent::invalidate($field, __($value, true));
	}
	*/
	
}