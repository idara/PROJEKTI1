<?php

class Path extends AppModel
{
    public $hasAndBelongsToMany = array(
        'Poll' => array(
            'joinTable' => 'polls_paths'
        )
    );

    function __construct() {
		parent::__construct();
		$this->validate = array(
			'name' => array(
				'not_empty' => array(
					'rule' => 'notEmpty',
					'message' => __('Anna aineistolle nimi.', true)
				),
				'unique' => array(
					'rule' => array('uniqueByUser', 'author_id'),
					'message' => __('Tämänniminen aineisto on jo olemassa, kokeile toista nimeä.', true)
				)
			),
			'coordinates' => array(
				'not_empty' => array(
					'rule' => 'notEmpty',
					'message' => __('Aineistolla täytyy olla sijainti, lisää se kartalle.', true)
				)
			)
		);
	}

    function uniqueByUser($check, $field){
        //$check = automaattisesti tarkastettava kenttä, $field = käyttäjän tunniste
        //debug($check);
        //debug($field);
        //debug($this->data['Path']);

        if (empty($this->data['Path']['id'])){ // jos on tallennettu
            $conditions = array(
                $field => $this->data['Path'][$field],  //Parametrinä annetu kenttä sisältää saman datan (eli esim. on käyttäjän oma data, eikä jonkun muun)
                'OR' => $check //sisältää tarkastetavan tiedon

            );
        } else { // jos ei ole tallennettu
            $conditions = array(
                $field => $this->data['Path'][$field],  //Parametrinä annetu kenttä sisältää saman datan (eli esim. on käyttäjän oma data, eikä jonkun muun)
                'OR' => $check, //sisältää tarkastetavan tiedon
                'NOT' => array(
                    'Path.id' => $this->data['Path']['id'] //Mutta ei laske itseään mukaan
                )
            );
        }

        $sameNameCount = $this->find('count', array('conditions' => $conditions));
        //debug($sameNameCount == 0); die;
        return $sameNameCount == 0; // jos ehdoilla löytyy osumia, niin ei ole uniikki käyttäjälle
    }
}
