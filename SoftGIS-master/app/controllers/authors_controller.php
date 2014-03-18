<?php

class AuthorsController extends AppController
{
	
	var $name = 'Authors';
	
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('register', 'login');
    }

    public function index()
    {
        $id = $this->Author->id = $this->Auth->user('id');
        $me = $this->Author->read();
        // debug($me);die;
        $this->set('me', $me);
    }

    public function login()
    {
        
    }

    public function register()
    {
        $secret = 'kalapuikko';

        if (!empty($this->data)) {
            if ($this->data['secret'] == $secret) {
                if ($this->Author->save($this->data)) {
                    $this->Session->setFlash('Rekisteröinti onnistui');
                    $this->Session->setFlash('Voit nyt kirjautua sisään');
                    $this->redirect(array('action' => 'login'));
                } else {
                    $this->data['Author']['password'] = '';
                }
            } else {
                $this->data['Author']['password'] = '';
                $this->set('secretWrong', true);
            }
        }
    }

    public function logout()
    {
        $this->redirect($this->Auth->logout());
    }
	
	//KÄYTTÄJÄHALLINTA

	//Sivutuskäyttäjälistalle
	var $paginate = array(
        'limit' => 25,
    );
	
	//Kaikkien käyttäjien listaus
	public function view() {
	
		$tuloste = "Kirjautunut käyttäjä: " . $this->Auth->user('id');
		$this->set('tuloste', $tuloste);
	
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{
	/*	//=============
			if($author['Author']['id']==$this->Auth->user('id'))
			{
				$confirmMessage = "Haluatko varmasti poistaa oman käyttäjätunnuksesi \"" . $author['Author']['username'] . "\"?";
				//Haluatko varmasti poistaa käyttäjän '%s'?", $author['Author']['username'];
			}
			elseif($author['Author']['id']!=$this->Auth->user('id'))
			{
				$confirmMessage = "Haluatko varmasti poistaa käyttäjätunnuksen \"" . $author['Author']['username'] . "\"?";
			}
			
			//$this->set('user', $this->Author->read(null, $id));
			$this->set("confirmMessage", $confirmMessage);
		//=============
		*/
		
			//Käyttäjälista
			$this->Author->recursive = 0;
			$this->set('authors', $this->paginate());
			
			//Kyselyiden määrä
			$this->set('pollsCount', $this->Author->query("SELECT authors.id, COUNT(polls.author_id) as lkm FROM authors INNER JOIN polls ON authors.id=polls.author_id GROUP BY authors.id;"));
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', ' - Käyttäjälista');
			
			$groups = $this->Author->Group->find('all');
			$this->set(compact('groups'));
		}
	}
	
	//Uuden käyttäjän lisääminen käyttäjähallinnan kautta
	function add() {
		
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{
			if (!empty($this->data)) {
				$this->Author->create();
				if ($this->Author->save($this->data)) {
					$this->Session->setFlash(__('Uusi käyttäjä lisätty', true));
					$this->redirect(array('action' => 'view'));
				} else {
					$this->Session->setFlash(__('Uutta käyttäjää ei voitu lisätä. Ole hyvä ja yritä uudestaan.', true));
				}
			}
			//$groups = $this->User->Group->find('list');
			//$this->set(compact('groups'));
			
			//Ryhmien nimet ja id:t ja nimet lomakkeen select-elementille
			$groups = $this->Author->Group->find('all');
			$this->set(compact('groups'));
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', ' - Lisää uusi käyttäjä');
		}
	}
	
	//Käyttäjän käyttäjänimen muokkaaminen
	function username($id = null) {
	
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Käyttäjää ei löydy', true));
				$this->redirect(array('action' => 'view'));
			}
			if (!empty($this->data)) {
				if ($this->Author->save($this->data)) {
					$this->Session->setFlash(__('Käyttäjän käyttäjänimeen tehdyt muutokset on tallennettu', true));
					$this->redirect(array('action' => 'view'));
				} else {
					$this->Session->setFlash(__('Muutosten tallentaminen ei onnistunut. Ole hyvä ja yritä uudestaan.', true));
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Author->read(null, $id);
			}
			
			//Käyttäjän tiedot näkymälle tulostettavaksi
			$this->set('user', $this->Author->read(null, $id));
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', ' - Muokkaa käyttäjän käyttäjänimeä');
		}
	}
	
	//Käyttäjän salasanan muokkaaminen
	function password($id = null) {
	
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Käyttäjää ei löydy', true));
				$this->redirect(array('action' => 'view'));
			}
			if (!empty($this->data)) {
				if ($this->Author->save($this->data)) {
					$this->Session->setFlash(__('Käyttäjän salasanaan tehdyt muutokset on tallennettu', true));
					$this->redirect(array('action' => 'view'));
				} else {
					$this->Session->setFlash(__('Muutosten tallentaminen ei onnistunut. Ole hyvä ja yritä uudestaan.', true));
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Author->read(null, $id);
			}
			
			//Käyttäjän tiedot näkymälle tulostettavaksi
			$this->set('user', $this->Author->read(null, $id));
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', ' - Muokkaa käyttäjän käyttäjänimeä');
		}
	}
	
	//Käyttäjän poistaminen
	/*
	
	$conditions = array("Post.title" => "This is a post");
	//Example usage with a model:
	$this->Post->find('first', array('conditions' => $conditions));
	
	deleteAll(mixed $conditions, $cascade = true, $callbacks = false)
	
	*/
	function delete($id = null) {
	
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{
		
			if (!$id) {
				$this->Session->setFlash(__('Käyttäjää ei löytynyt.', true));
				$this->redirect(array('action'=>'view'));
			}
			
			//$conditions = array("Post.title" => "This is a post");
			//Example usage with a model:
			//$this->Post->find('first', array('conditions' => $conditions));
			
			$conditions = array("Author.id" => $id);

			if ($this->Author->deleteAll($conditions, $cascade = true)) {
			
				if($id==$this->Auth->user('id'))
				{
					$this->Session->setFlash(__('Poistit oman käyttäjätunnuksesi', true));
					$this->redirect(array('action' => 'logout'));
				}
				else
				{
					$this->Session->setFlash(__('Käyttäjä poistettu.', true));
					$this->redirect(array('action'=>'view'));
				}
			}
			$this->Session->setFlash(__('Käyttäjää ei voitu poistaa.', true));
			$this->redirect(array('action' => 'view'));
		}
	}
	
	// Manuaalisen poistotoiminnon väkertely
	/*
	function testi($id = null)
	{
		if (!empty($id))
		{
			//Haetaan käyttäjän kaikki kyselyt
			$query = "SELECT polls.id FROM polls WHERE polls.author_id='" . $id . "';";
			$polls = $this->Author->query($query);
			
			//Käydään jokainen kysely yksitellen läpi
			foreach($polls as $poll_id)
			{
				if(!empty($poll_id))
				{
					$poll = $this->Poll->find(
						'first',
						array(
							'conditions' => array(
								'Poll.id' => $poll_id
							),
							'contain' => array(
								'Question' => array('id'),
								'Response'=> array('id'),
								'Hash' => array('id'),
								'Path' => array('id'),
								'Marker' => array('id' ),
								'Overlay' => array('id')
							)
						)
					);
					
					// Poll not found or someone elses
					if (empty($poll)) {
						//$this->cakeError('pollNotFound');
						$this->Session->setFlash(__('Poll not found or someone elses', true));//########################
						$this->redirect(array('action' => 'view'));
					} else {
						//Haetaan myös vastaukset
						$poll['Answer'] = array();
						foreach ($poll['Response'] as $i => $v) {
							$poll['Answer'][$i] = $this->Answer->find('all', array('conditions' => array('Answer.response_id' => $v['id']), 'recursive' => -1, 'fields' => array('id')));
						}

						//sitten poistamaan:
						foreach ($poll['Answer'] as $i => $v) {
							foreach ($v as $vi => $vv) {
								$this->Answer->delete($vv['Answer']['id'], false);
							}
						}

						foreach ($poll['Overlay'] as $i => $v) {
							$this->Poll->Overlay->PollsOverlay->delete($v['PollsOverlay']['id'], false);
						}
						foreach ($poll['Marker'] as $i => $v) {
							$this->Poll->Marker->PollsMarker->delete($v['PollsMarker']['id'], false);
						}
						foreach ($poll['Path'] as $i => $v) {
							$this->Poll->Path->PollsPath->delete($v['PollsPath']['id'], false);
						}
						foreach ($poll['Hash'] as $i => $v) {
							$this->Poll->Hash->delete($v['id'], false);
						}
						foreach ($poll['Response'] as $i => $v) {
							$this->Poll->Response->delete($v['id'], false);
						}
						foreach ($poll['Question'] as $i => $v) {
							$this->Poll->Question->delete($v['id'], false);
						}
						$this->Poll->delete($poll['Poll']['id'], false);


						$this->Session->setFlash('Kysely poistettu');
						$this->redirect(array('action' => 'index'));
					}
				}
				else
				{
				// jos kyselyä ei löytynyt
				//$this->cakeError('pollNotFound');
				$this->Session->setFlash(__('jos kyselyä ei löytynyt', true));//########################
				$this->redirect(array('action' => 'index'));
				}
			}
			
			$this->Author->delete($id);
		}
	}
	*/
	
	//Ryhmän vaihtaminen
	function group($id = null) {
	
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Käyttäjää ei löydy', true));
				$this->redirect(array('action' => 'view'));
			}
			if (!empty($this->data)) {
				if ($this->Author->save($this->data)) {
					$this->Session->setFlash(__('Käyttäjään tehdyt muutokset on tallennettu', true));
					$this->redirect(array('action' => 'view'));
				} else {
					$this->Session->setFlash(__('Muutosten tallentaminen ei onnistunut. Ole hyvä ja yritä uudestaan.', true));
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Author->read(null, $id);
			}
			
			//Käyttäjän tiedot näkymälle tulostettavaksi
			$this->set('user', $this->Author->read(null, $id));
			
			//Ryhmien nimet ja id:t ja nimet lomakkeen select-elementille
			$groups = $this->Author->Group->find('all');
			$this->set(compact('groups'));
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', ' - Muokkaa käyttäjän tietoja');
		}
	}
	
	//   / KÄYTTÄJÄHALLINTA
	
}