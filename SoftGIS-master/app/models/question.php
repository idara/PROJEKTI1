<?php

class Question extends AppModel
{
    public $actsAs = array(
        'LatLng'
    );

    public $hasMany = array(
        'Answer' => array(
			'dependent'    => true//LISÄTTY
        )
    );

    public $belongsTo = array(
        'Poll' => array(
			'dependent'    => true//LISÄTTY
        )
    );

    public function afterFind($results, $primary)
    {
        if (!$primary) {
            return $this->Behaviors->LatLng->afterFind($this, $results, false);
        } else {
            return $results;
        }
    }
}
