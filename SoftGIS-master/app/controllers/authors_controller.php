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
	
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{
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
			if ($this->Author->delete($id, $cascade = true)) {
				$this->Session->setFlash(__('Käyttäjä poistettu.', true));
				$this->redirect(array('action'=>'view'));
			}
			$this->Session->setFlash(__('Käyttäjää ei voitu poistaa.', true));
			$this->redirect(array('action' => 'view'));
		}
	}
	
	
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