<?php

class RequestsController extends AppController
{
	var $name = 'Requests';
	
	function beforeFilter() {
        $this->Auth->allow('forgotpassword');
	}
	
	//  Tukipyynnöt

	//Avoimien tukipyyntöjen listaus
    public function index()
    {
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta tukipyyntöjen käsittelyyn.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{		
			$this->Request->recursive = 0;
			$this->paginate = array(
				'conditions' => array('Request.complete' => '0'),
				'order' => array('Request.request_created DESC') //string or array defining order DESC
			);
			$this->set('requests', $this->paginate());
			
			$this->set('requestors', $this->Request->query("SELECT requests.author_id, authors.username, authors.email FROM requests INNER JOIN authors ON requests.author_id=authors.id GROUP BY requests.author_id;"));
			
			//SELECT requests.author_id, authors.username FROM requests INNER JOIN authors ON requests.author_id=authors.id GROUP BY requests.author_id;
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', __(' - Ryhmälista', true));
		}
    }
	
	//Avoimien tukipyyntöjen listaus
    public function viewcomplited()
    {
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta tukipyyntöjen käsittelyyn.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{			
			$this->Request->recursive = 0;
			$this->paginate = array(
				'conditions' => array('Request.complete' => '1'),
				'order' => array('Request.request_created DESC') //string or array defining order DESC
			);
			$this->set('requests', $this->paginate());
			
			$this->set('requestors', $this->Request->query("SELECT requests.author_id, authors.username, authors.email FROM requests INNER JOIN authors ON requests.author_id=authors.id GROUP BY requests.author_id;"));
			
			//SELECT requests.author_id, authors.username FROM requests INNER JOIN authors ON requests.author_id=authors.id GROUP BY requests.author_id;
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', __(' - Ryhmälista', true));
		}
    }


	//Sivutus tukipyyntölistalle
	var $paginate = array(
        'limit' => 25,
    );
	
	//Uuden tukipyynnön lähettäminen
	function add() {
		
		// Sähköpostiosoitteen syöttämisen muistutus
		$this->set('emailLen', strlen($this->Auth->user('email')));
		
		$this->set('AuthorizedUserId', $this->Auth->user('id'));
		$this->set('timestamp', date("Y-m-d H:i:s"));
	
		if (!empty($this->data))
		{
			$this->Request->create();
			if ($this->Request->save($this->data)) {
				$this->Session->setFlash(__('Tukipyyntö tallennettu', true));
				$this->redirect(array('controller' => 'authors', 'action' => 'profile'));
			} else {
				$this->Session->setFlash(__('Tukipyyntöä ei voitu tallentaa. Ole hyvä ja yritä uudestaan.', true));
			}
		}	
		
		//Asetetaan layout -> Navigointi näkyviin
		$this->layout = 'author';
		
		//Asetetaan sivun otsikko
		$this->set('title_for_layout', __(' - Lähetä tukipyyntö', true));
	}
	
	//Salasana unohtunut -> Uuden salasanan pyytäminen kirjautumissivulta
	function forgotpassword() {
		
		$this->set('timestamp', date("Y-m-d H:i:s"));
	
		if (!empty($this->data))
		{
			$this->Request->create();
			
			// Haetaan käyttäjän id sähköpostiosoitteen perusteella
			$reuquestorEmail = '\'' . $this->data['Request']['email'] . '\'';
			$requestorId = $this->Request->query("SELECT authors.id FROM authors WHERE authors.email=$reuquestorEmail;");
			
			if(isset($requestorId['0']['authors']['id']))
			{				
				$this->data['Request']['author_id'] = $requestorId['0']['authors']['id'];
				
				$this->data['Request']['request_created'] = date("Y-m-d H:i:s");
				
				$this->data['Request']['request'] = __('Olen unohtanut salasanani. En pääse kirjautumaan sisään. Voisitteko toimittaa minulle uuden salasanan? TÄMÄ VAKIOMUOTOINEN PYYNTÖ ON LÄHETETTY KIRJAUTUMISSIVUN KAUTTA!', true);
				
				if ($this->Request->save($this->data))
				{
					$this->Session->setFlash(__('Salasanan uusimispyyntö lähetetty', true));
					$this->redirect(array('controller' => 'authors', 'action' => 'profile'));
				} else {
					$this->Session->setFlash(__('Salasanan uusimispyyntöä ei voitu lähettää. Ole hyvä ja yritä uudestaan.', true));
				}
			}
			else
			{
				$this->Request->invalidate( 'email', __('Sähköpostiosoitetta ei löytynyt.', true) );
			}
		}	
		
		//Asetetaan layout -> Navigointi näkyviin
		//$this->layout = 'author';
		
		//Asetetaan sivun otsikko
		$this->set('title_for_layout', __(' - Lähetä tukipyyntö', true));
	}
	

	//Tukipyynnön poistaminen
	function delete($id = null) {
	
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta tukipyyntöjen käsittelyyn.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{
			if (!$id) {
				$this->Session->setFlash(__('Tukipyyntöä ei löytynyt.', true));
				$this->redirect(array('action'=>'index'));
			}
			if ($this->Request->delete($id)) {
				$this->Session->setFlash(__('Tukipyyntö poistettu.', true));
				$this->redirect(array('action'=>'index'));
			}
			$this->Session->setFlash(__('Tukipyyntöä ei voitu poistaa.', true));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	//Merkitse tukipyyntö käsitellyksi
	function complete($id = null) {
	
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta tukipyyntöjen käsittelyyn.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{
			if (!$id) {
				$this->Session->setFlash(__('Tukipyyntöä ei löydy', true));
				$this->redirect(array('action' => 'index'));
			}
			if ($this->Request->query("UPDATE requests SET complete=1 WHERE id=$id;")) {
				$this->Session->setFlash(__('Tukipyyntö merkitty käsitellyksi', true));
				$this->redirect(array('action' => 'index'));
			}
			else
			{
				$this->Session->setFlash(__('Muutosten tallentaminen ei onnistunut. Ole hyvä ja yritä uudestaan.', true));
			}
		}
	}
	
	//Merkitse tukipyyntö käsittelemättömäksi
	function uncomplete($id = null) {
	
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta tukipyyntöjen käsittelyyn.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{
			if (!$id) {
				$this->Session->setFlash(__('Tukipyyntöä ei löydy', true));
				$this->redirect(array('action' => 'viewcomplited'));
			}
			if ($this->Request->query("UPDATE requests SET complete=0 WHERE id=$id;")) {
				$this->Session->setFlash(__('Tukipyyntö merkitty käsittelemättömäksi', true));
				$this->redirect(array('action' => 'viewcomplited'));
			}
			else
			{
				$this->Session->setFlash(__('Muutosten tallentaminen ei onnistunut. Ole hyvä ja yritä uudestaan.', true));
			}
		}
	}
	
	
	//   / Tukipyynnöt
	
}