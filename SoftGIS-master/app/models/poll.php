<?php

class Poll extends AppModel
{
    public $hasMany = array(
        'Question' => array(
            'foreign_key' => 'poll_id',
            'order' => 'Question.num ASC',
			'dependent'    => true//LISÄTTY
        ),
        'Response' => array(
			//'foreign_key' => 'poll_id',//LISÄTTY
            'order' => 'Response.created ASC',
			'dependent'    => true//LISÄTTY
        ),
        'Hash' => array(
			//'foreign_key' => 'poll_id',//LISÄTTY
            'order' => 'Hash.used ASC',
			'dependent'    => true//LISÄTTY
        )
    );

    public $hasAndBelongsToMany = array(
        'Path' => array(
            'joinTable' => 'polls_paths',
            'unique' => true,
			'dependent'    => true//LISÄTTY
        ),
        'Marker' => array(
            'joinTable' => 'polls_markers',
            'unique' => true,
			'dependent'    => true//LISÄTTY
        ),
        'Overlay' => array(
            'joinTable' => 'polls_overlays',
            'unique' => true,
			'dependent'    => true//LISÄTTY
        )
    );

    public $validate = array(
        'name' => array(
            'not_empty' => array(
                'rule' => 'notEmpty',
                'message' => 'Anna kyselylle nimi'
            ),
            'unique' => array(
                'rule' => array('uniqueByUser', 'author_id'),
                'message' => 'Tämänniminen kysely on jo olemassa, kokeile toista nimeä.'
            )
        )
    );

    function uniqueByUser($check, $field){
        //$check = automaattisesti tarkastettava kenttä, $field = käyttäjän tunniste
        //debug($check);
        //debug($field);
        //debug($this->data['Poll']);

        if (empty($this->data['Poll']['id'])){ // jos on tallennettu
            $conditions = array(
                $field => $this->data['Poll'][$field],  //Parametrinä annetu kenttä sisältää saman datan (eli esim. on käyttäjän oma data, eikä jonkun muun)
                'OR' => $check //sisältää tarkastetavan tiedon

            );
        } else { // jos ei ole tallennettu
            $conditions = array(
                $field => $this->data['Poll'][$field],  //Parametrinä annetu kenttä sisältää saman datan (eli esim. on käyttäjän oma data, eikä jonkun muun)
                'OR' => $check, //sisältää tarkastetavan tiedon
                'NOT' => array(
                    'Poll.id' => $this->data['Poll']['id'] //Mutta ei laske itseään mukaan
                )
            );
        }

        $sameNameCount = $this->find('count', array('conditions' => $conditions));
        //debug($sameNameCount == 0); //die;
        return $sameNameCount == 0; // jos ehdoilla löytyy osumia, niin ei ole uniikki käyttäjälle
    }

    public function validHash($hashStr)
    {
        App::import('Model', 'Hash');
        $hashModel = new Hash();

        $hash = $hashModel->find(
            'first',
            array(
                'conditions' => array(
                    'Hash.hash' => $hashStr,
                    'Hash.poll_id' => $this->id,
                    'Hash.used' => '0'
                )
            )
        );
        return !empty($hash);
    }

    public function generateHashes($count)
    {
        App::import('Model', 'Hash');

        $hash = new Hash();

        for ($i = 0; $i < $count; $i++) {
            $str = md5(uniqid(rand(), true));
            $hash->create(
                array(
                    'poll_id' => $this->id,
                    'hash' => $str,
                    'used' => 0
                )
            );
            $hash->save();
        }

    }

    public function beforeSave($options = array())
    {
        if (isset($this->data['Poll']['launch'])) {
            if (empty($this->data['Poll']['launch'])) {
                $this->data['Poll']['launch'] = null;
            }
        }
        if (isset($this->data['Poll']['end'])) {
            if (empty($this->data['Poll']['end'])) {
                $this->data['Poll']['end'] = null;
            }
        }
        return true;
    }
}


