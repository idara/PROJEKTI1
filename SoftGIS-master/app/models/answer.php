<?php

class Answer extends AppModel
{
    public $belongsTo = array(
        'Question' => array(
			'dependent'    => true//LISÄTTY
        ),
        'Response' => array(
			'dependent'    => true//LISÄTTY
        )
    );
}
