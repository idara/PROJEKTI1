<?php

class Marker extends AppModel
{
    public $actsAs = array(
        'LatLng'
    );

    public $hasAndBelongsToMany = array(
        'Poll' => array(
            'joinTable' => 'polls_markers'
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

    function __construct()
	{
		parent::__construct();

		$this->validate = array(
			'name' => array(
				'not_empty' => array(
					'rule' => 'notEmpty',
					'message' => __('Anna merkille nimi.', true)
				),
				'unique' => array(
					'rule' => array('uniqueByUser', 'author_id'),
					'message' => __('Tämänniminen merkki on jo olemassa, kokeile toista nimeä.', true)
				)
			),
			'lat' => array(
				'not_empty' => array(
					'rule' => 'notEmpty',
					'message' => __('Merkillä täytyy olla sijainti, lisää se kartalle.', true)
				)
			),
			'lng' => array(
				'not_empty' => array(
					'rule' => 'notEmpty',
					'message' => __('Merkillä täytyy olla sijainti, lisää se kartalle.', true)
				)
			)
		);
	}

    function uniqueByUser($check, $field){
        //$check = automaattisesti tarkastettava kenttä, $field = käyttäjän tunniste
        //debug($check);
        //debug($field);
        //debug($this->data['Marker']);

        if (empty($this->data['Marker']['id'])){ // jos on tallennettu
            $conditions = array(
                $field => $this->data['Marker'][$field],  //Parametrinä annetu kenttä sisältää saman datan (eli esim. on käyttäjän oma data, eikä jonkun muun)
                'OR' => $check //sisältää tarkastetavan tiedon

            );
        } else { // jos ei ole tallennettu
            $conditions = array(
                $field => $this->data['Marker'][$field],  //Parametrinä annetu kenttä sisältää saman datan (eli esim. on käyttäjän oma data, eikä jonkun muun)
                'OR' => $check, //sisältää tarkastetavan tiedon
                'NOT' => array(
                    'Marker.id' => $this->data['Marker']['id'] //Mutta ei laske itseään mukaan
                )
            );
        }

        $sameNameCount = $this->find('count', array('conditions' => $conditions));
        //debug($sameNameCount == 0); die;
        return $sameNameCount == 0; // jos ehdoilla löytyy osumia, niin ei ole uniikki käyttäjälle
    }
}
