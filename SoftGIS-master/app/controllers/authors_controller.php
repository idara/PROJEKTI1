<?php

class AuthorsController extends AppController
{

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
	
		if(($this->Auth->user('accessControl'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{
			$this->Author->recursive = 0;
			$this->set('authors', $this->paginate());
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', ' - Käyttäjälista');
		}
	}
	
	//Uuden käyttäjän lisääminen käyttäjähallinnan kautta
	function add() {
		
		if(($this->Auth->user('accessControl'))!=1)
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
			
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', ' - Lisää uusi käyttäjä');
		}
	}
	
	//Käyttäjän muokkaaminen
	function edit($id = null) {
	
		if(($this->Auth->user('accessControl'))!=1)
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
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', ' - Muokkaa käyttäjän tietoja');
		}
	}
	
	//Käyttäjän poistaminen
	function delete($id = null) {
	
		if(($this->Auth->user('accessControl'))!=1)
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
			if ($this->Author->delete($id)) {
				$this->Session->setFlash(__('Käyttäjä poistettu.', true));
				$this->redirect(array('action'=>'view'));
			}
			$this->Session->setFlash(__('Käyttäjää ei voitu poistaa.', true));
			$this->redirect(array('action' => 'view'));
		}
	}
	
	//Kaikkien käyttäjien listaus
	public function access_control_edit($id = null) {

		if(($this->Auth->user('accessControl'))!=1)
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
			
				$user = $this->Author->findById($id);
				$this->set('user', $user);
				
				if ($this->Author->save($this->data)) {
					$this->Session->setFlash(__('Käyttäjän hallintaoikeuksiin tehdyt muutokset on tallennettu', true));
					$this->redirect(array('action' => 'view'));
				} else {
					$this->Session->setFlash(__('Muutosten tallentaminen ei onnistunut. Ole hyvä ja yritä uudestaan.', true));
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Author->read(null, $id);
			}

			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', ' - Muokkaa käyttäjän tietoja');
		}
	}
	
	//   / KÄYTTÄJÄHALLINTA
	
}