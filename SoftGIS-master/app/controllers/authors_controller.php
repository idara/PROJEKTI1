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
                    $this->Session->setFlash(__('Rekisteröinti onnistui'));
                    $this->Session->setFlash(__('Voit nyt kirjautua sisään'));
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
	
		//$tuloste = "Kirjautunut käyttäjä: " . $this->Auth->user('id');
		//$this->set('tuloste', $tuloste);
		$this->set('authorizedUserId', $this->Auth->user('id'));
	
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
			$this->set('title_for_layout', __(' - Käyttäjälista', true));
			
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
			$this->set('title_for_layout', __(' - Lisää uusi käyttäjä', true));
		}
	}
	
	//Käyttäjän käyttäjänimen muokkaaminen
	function username($id = null) {
	
		if(($this->Auth->user('group_id'))==1)
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
			$this->set('title_for_layout', __(' - Muokkaa käyttäjän käyttäjänimeä', true));
		}
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	
	//Käyttäjän salasanan muokkaaminen
	function password($id = null) {
	
		if(($this->Auth->user('group_id'))==1)
		{
			if(isset($_GET["source"]))
			{
				$this->set('source', $_GET["source"]);
			}
			else
			{
				$this->set('source', "");
			}
			
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
			$this->set('title_for_layout', __(' - Muokkaa käyttäjän salasanaa', true));
		}
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	
	//Käyttäjän poistaminen
	function delete($id = null) {
		/*	
		$conditions = array("Post.title" => "This is a post");
		//Example usage with a model:
		$this->Post->find('first', array('conditions' => $conditions));
		
		deleteAll(mixed $conditions, $cascade = true, $callbacks = false)
		*/
	
		if(($this->Auth->user('group_id'))==1)
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
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	
	
	//Ryhmän vaihtaminen
	function group($id = null) {
	
		if(($this->Auth->user('group_id'))==1)
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
			$this->set('title_for_layout', __(' - Vaihda ryhmää', true));
		}
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	
	//Omien tietojen hallinta
	
	//Profiili - Etusivu
	function profile() {
	
		//Käyttäjän id
		$id = $this->Auth->user('id');
	
		//Käyttäjän tiedot
		$this->set('author', $this->Author->query("SELECT authors.id, authors.username, authors.password, authors.group_id FROM authors WHERE authors.id=$id;"));
		
		//Kyselyiden määrä
		$this->set('pollsCount', $this->Author->query("SELECT authors.id, COUNT(polls.author_id) as lkm FROM authors INNER JOIN polls ON authors.id=polls.author_id GROUP BY authors.id;"));
		
		//Kyselyiden määrä
		$this->set('pollsCount', $this->Author->query("SELECT author_id, COUNT(author_id) as lkm FROM polls WHERE author_id=$id;"));
		
		//Julkisten kyselyiden määrä
		$this->set('publicPollsCount', $this->Author->query("SELECT author_id, COUNT(author_id) as lkm FROM polls WHERE author_id=$id AND public='1';"));
		
		//Avoimien kyselyiden määrä
		$now = date("Y-m-d");
		$this->set('openPollsCount', $this->Author->query("SELECT author_id, COUNT(author_id) as lkm FROM polls WHERE author_id=$id AND ('2014-03-20' BETWEEN `launch` AND `end`);"));
		
		//Asetetaan layout -> Navigointi näkyviin
		$this->layout = 'author';
		
		//Asetetaan sivun otsikko
		$this->set('title_for_layout', __(' - Omien tietojen hallinta', true));
		
		$groups = $this->Author->Group->find('all');
		$this->set(compact('groups'));
	}
	
	//Profiili - Käyttäjänimen muokkaaminen
	function profile_username() {
	
		$id = $this->Auth->user('id');
	
		if(($this->Auth->user('id'))==$id)
		{
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Käyttäjää ei löydy', true));
				$this->redirect(array('action' => 'profile'));
			}
			if (!empty($this->data)) {
				if ($this->Author->save($this->data)) {
					$this->Session->setFlash(__('Käyttäjän käyttäjänimeen tehdyt muutokset on tallennettu', true));
					$this->redirect(array('action' => 'profile'));
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
			$this->set('title_for_layout', __(' - Muokkaa omaa käyttäjätunnusta', true));
		}
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	
	//Käyttäjän salasanan muokkaaminen
	function profile_password() {
	
		$id = $this->Auth->user('id');
	
		if(($this->Auth->user('id'))==$id)
		{			
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Käyttäjää ei löydy', true));
				$this->redirect(array('action' => 'profile'));
			}
			if (!empty($this->data)) {
				if ($this->Author->save($this->data)) {
					$this->Session->setFlash(__('Käyttäjän salasanaan tehdyt muutokset on tallennettu', true));
					$this->redirect(array('action' => 'profile'));
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
			$this->set('title_for_layout', __(' - Muokkaa omaa salasanaa', true));
		}
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	
	//Käyttäjän poistaminen
	function profile_delete() {
	
		$id = $this->Auth->user('id');
	
		if(($this->Auth->user('id'))==$id)
		{
		
			if (!$id) {
				$this->Session->setFlash(__('Käyttäjää ei löytynyt.', true));
				$this->redirect(array('action'=>'profile'));
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
					$this->redirect(array('action'=>'profile'));
				}
			}
			$this->Session->setFlash(__('Käyttäjää ei voitu poistaa.', true));
			$this->redirect(array('action' => 'profile'));
		}
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	
	
	//Ryhmän vaihtaminen
	function profile_group() {
	
		$id = $this->Auth->user('id');
	
		if(($this->Auth->user('id'))==$id)
		{			
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Käyttäjää ei löydy', true));
				$this->redirect(array('action' => 'profile'));
			}
			if (!empty($this->data)) {
				if ($this->Author->save($this->data)) {
					$this->Session->setFlash(__('Käyttäjään tehdyt muutokset on tallennettu', true));
					$this->redirect(array('action' => 'profile'));
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
			$this->set('title_for_layout', __(' - Vaihda ryhmää', true));
		}
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	
	//  /Omien tietojen hallinta
	
	//   / KÄYTTÄJÄHALLINTA
	
}